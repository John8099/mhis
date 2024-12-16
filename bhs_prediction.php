<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
    header('Location: index.php');
    exit();
}

include('includes/header.php');
include('includes/midwife_navbar.php');
$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationID 
          FROM user u 
          LEFT JOIN station s ON u.stationID = s.stationID 
          WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $stationID = $user_data['stationID'];
}
$selectedBarangay = isset($_POST['barangay']) ? $_POST['barangay'] : 0;

$barangays = [];
$patients = [];
$riskLevels = [
    'Low Risk' => 0,
    'High Risk' => 0,
    'Pre-term' => 0,
    'Fatal Death' => 0
];
$monthlyCounts = array_fill(1, 12, $riskLevels); 

if ($stationID) {
    $barangayQuery = "SELECT * FROM barangay WHERE stationID = '$stationID' ORDER BY barangayName ASC"; 
    $barangayResult = mysqli_query($conn, $barangayQuery);

    while ($row = mysqli_fetch_assoc($barangayResult)) {
        $barangays[] = $row;
    }
    if ($selectedBarangay == 0 && !empty($barangays)) {
        $selectedBarangay = $barangays[0]['barangayID'];
    }
}

if ($selectedBarangay) {
    $patientQuery = "
        SELECT p.*, pn.pnParity 
        FROM patient p
        LEFT JOIN `pre-natal_info` pn ON p.patientID = pn.patientID
        WHERE p.barangayID = '$selectedBarangay'
        ORDER BY p.patientFname ASC
    ";
    $patientResult = mysqli_query($conn, $patientQuery);

    while ($row = mysqli_fetch_assoc($patientResult)) {
        $patients[] = $row;
    }
}
?>
<div class="container">
    <div class="row my-2">
        <div class="col-lg-12">
            <div class="card shadow my-2">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Prediction</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <select name="barangay" class="form-control" id="barangay" onchange="this.form.submit()">
                                    <option value="0" disabled selected>Select Barangay</option>
                                    <?php
                                    foreach ($barangays as $row) {
                                        $barangayID = $row['barangayID'];
                                        $barangayName = $row['barangayName'];

                                        $selected = ($barangayID == $selectedBarangay) ? 'selected' : ''; 
                                        echo "<option value=\"$barangayID\" $selected>$barangayName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered text-center" style="<?php echo $selectedBarangay ? 'display:table;' : 'display:none;'; ?>">
                        <thead>
                            <tr>
                                <th>Family Serial Number</th>
                                <th>Name</th>
                                <th>Risk Level</th>
                                <th>Predicted Outcome</th>
                                <th>Actual Outcome</th>
                                <th>Accuracy Rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($patients) > 0): ?>
                                <?php foreach ($patients as $patient): 
                                    $riskLevel = 'Low Risk';
                                    $predictedOutcome = 'Full Term';
                                    $actualOutcome = '-';

                                    $patientID = $patient['patientID'];
                                    $patientAge = $patient['patientAge'] ?? null;
                                    $parity = $patient['parity'] ?? null;

                                    // AGE
                                    if ($patientAge < 18 || $patientAge > 35) {
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Pre-term';
                                    }
                                    // PARITY
                                    if ($parity == 1 || $parity >= 5) {
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Pre-term';
                                    }
                                    // BMI
                                    $bmi = $patient['patientBMI'] ?? null;
                                    if ($bmi < 18.5 || $bmi > 29.9) {
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Pre-term';
                                    }
                                    // GESTATIONAL AND CBC
                                    $labQuery = "SELECT gestationalResult, cbcHgbHctResult FROM laboratory WHERE patientID = '$patientID'";
                                    $labResult = mysqli_query($conn, $labQuery);
                                    $labData = mysqli_fetch_assoc($labResult);
                                    if ($labData['gestationalResult'] == 1) {
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Pre-term';
                                    }
                                    if ($labData['cbcHgbHctResult'] == 1) { 
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Pre-term';
                                    }
                                    // HEPATITIS AND SYPHILIS
                                    $infectiousQuery = "SELECT hepatitisResult, syphilisResult FROM infectious WHERE patientID = '$patientID'";
                                    $infectiousResult = mysqli_query($conn, $infectiousQuery);
                                    $infectiousData = mysqli_fetch_assoc($infectiousResult);

                                    if ($infectiousData['hepatitisResult'] == 1) { 
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Fatal Death';
                                    }

                                    if ($infectiousData['syphilisResult'] == 1) { 
                                        $riskLevel = 'High Risk';
                                        $predictedOutcome = 'Pre-term';
                                    }
                                    
                                      // ACTUAL OUTCOME
                                    $outcomeQuery = "SELECT poOutcome FROM pregnancy_outcome WHERE patientID = '$patientID'";
                                    $outcomeResult = mysqli_query($conn, $outcomeQuery);
                                    $outcomeData = mysqli_fetch_assoc($outcomeResult);

                                    if ($outcomeData && !empty($outcomeData['poOutcome'])) {
                                        $actualOutcome = $outcomeData['poOutcome'];
                                    }
                                     // Calculate accuracy percentage for the patient
                                    if (
                                        ($actualOutcome == "FT" && $predictedOutcome == "Full Term") ||
                                        ($actualOutcome == "PT" && $predictedOutcome == "Pre-term") ||
                                        ($actualOutcome == "FD" && $predictedOutcome == "Fatal Death")
                                    ) {
                                        $accuracyPercentage = 100; // Perfect prediction
                                    } else {
                                        $accuracyPercentage = 0; // Incorrect prediction
                                    }   
                                    if (
                                        ($actualOutcome == "FT" && $predictedOutcome == "Full Term") ||
                                        ($actualOutcome == "PT" && $predictedOutcome == "Pre-term") ||
                                        ($actualOutcome == "FD" && $predictedOutcome == "Fatal Death")
                                    ) {
                                        $correctPredictions= 0;
                                    }
                                    // MONTHLY RISK LEVEL COUNTS
                                    $registrationDate = new DateTime($patient['registrationDate']); 
                                    $month = (int) $registrationDate->format('m'); 

                                    if ($riskLevel == 'High Risk') {
                                        $monthlyCounts[$month]['High Risk']++;
                                    } elseif ($predictedOutcome == 'Pre-term') {
                                        $monthlyCounts[$month]['Pre-term']++;
                                    } elseif ($predictedOutcome == 'Fatal Death') {
                                        $monthlyCounts[$month]['Fatal Death']++;
                                    } else {
                                        $monthlyCounts[$month]['Low Risk']++;
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $patient['patientSerialNumber'] ?? 'N/A'; ?></td>
                                        <td><?php echo trim("{$patient['patientFname']} {$patient['patientMname']} {$patient['patientLname']}"); ?></td>
                                        <td><?php echo $riskLevel; ?></td>
                                        <td><?php echo $predictedOutcome; ?></td>
                                        <td>
                                            <?php 
                                                if ($actualOutcome == "FT") {
                                                    echo "Full Term";
                                                } elseif ($actualOutcome == "PT") {
                                                    echo "Pre-term";
                                                } elseif ($actualOutcome == "FD") {
                                                    echo "Fatal Death";
                                                } else {
                                                    echo $actualOutcome; 
                                                }
                                            ?>
                                        </td>
                                        
                                        <td>
                                        
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?php echo $patient['patientID']; ?>">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No patients found for the selected barangay.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Chart Section -->
                    <div class="card-body text-center" style="<?php echo $selectedBarangay ? 'display:block;' : 'display:none;'; ?>">
                        <canvas id="riskLevelChart"></canvas>
                    </div>

                    <?php foreach ($patients as $patient): ?>
                        <div class="modal fade" id="detailsModal<?php echo $patient['patientID']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel<?php echo $patient['patientID']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailsModalLabel<?php echo $patient['patientID']; ?>">Patient Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php 
                                        // Fetch lab and infectious data specific to the current patient
                                        $labQuery = "SELECT gestationalResult, cbcHgbHctResult FROM laboratory WHERE patientID = '{$patient['patientID']}'";
                                        $labResult = mysqli_query($conn, $labQuery);
                                        $labData = mysqli_fetch_assoc($labResult);

                                        $infectiousQuery = "SELECT hepatitisResult, syphilisResult FROM infectious WHERE patientID = '{$patient['patientID']}'";
                                        $infectiousResult = mysqli_query($conn, $infectiousQuery);
                                        $infectiousData = mysqli_fetch_assoc($infectiousResult);
                                        ?>
                                        <p><strong>Name:</strong> <?php echo trim("{$patient['patientFname']} {$patient['patientMname']} {$patient['patientLname']}"); ?></p>
                                        <p><strong>Family Serial Number:</strong> <?php echo $patient['patientSerialNumber'] ?? 'N/A'; ?></p>
                                        <p><strong>Age:</strong> <?php echo $patient['patientAge'] ?? 'N/A'; ?> - <?php echo ($patient['patientAge'] < 18 || $patient['patientAge'] > 35) ? 'High Risk' : 'Low Risk'; ?></p>
                                        <p><strong>Parity:</strong> <?php echo $patient['pnParity'] ?? 'N/A'; ?> - <?php echo ($patient['pnParity'] == 1 || $patient['pnParity'] >= 5) ? 'High Risk' : 'Low Risk'; ?></p>
                                        <p><strong>BMI:</strong> <?php echo $patient['patientBMI'] ?? 'N/A'; ?> - <?php echo ($patient['patientBMI'] < 18.5 || $patient['patientBMI'] > 29.9) ? 'High Risk' : 'Low Risk'; ?></p>
                                        <p><strong>Gestational Result:</strong> <?php echo $labData['gestationalResult'] == 1 ? 'Positive - High Risk' : 'Negative - Low Risk'; ?></p>
                                        <p><strong>CBC Result:</strong> <?php echo $labData['cbcHgbHctResult'] == 1 ? 'With Anemia - High Risk' : 'Normal - Low Risk'; ?></p>
                                        <p><strong>Hepatitis B:</strong> <?php echo $infectiousData['hepatitisResult'] == 1 ? 'Positive - High Risk' : 'Negative - Low Risk'; ?></p>
                                        <p><strong>Syphilis:</strong> <?php echo $infectiousData['syphilisResult'] == 1 ? 'Positive - High Risk' : 'Negative - Low Risk'; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('riskLevelChart').getContext('2d');
    const riskLevels = <?php echo json_encode($monthlyCounts); ?>;
    const labels = Object.keys(riskLevels);
    const lowRiskData = labels.map(month => riskLevels[month]['Low Risk']);
    const highRiskData = labels.map(month => riskLevels[month]['High Risk']);

    const riskLevelChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(month => month), 
            datasets: [
                {
                    label: 'Low Risk',
                    data: lowRiskData,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                },
                {
                    label: 'High Risk',
                    data: highRiskData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 4},
                }
            }
        }
    });
</script>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>