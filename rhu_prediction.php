<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
  header('Location: index.php');
  exit();
}

include('includes/header.php');
include('includes/rhu_navbar.php');

$selectedStation = isset($_POST['station']) ? $_POST['station'] : 0;
$selectedBarangay = isset($_POST['barangay']) ? $_POST['barangay'] : 0;

$barangays = [];
$patients = [];

// For Station Selection
if ($selectedStation) {
  $barangayQuery = "SELECT * FROM barangay WHERE stationID = '$selectedStation' ORDER BY barangayName ASC";
  $barangayResult = mysqli_query($conn, $barangayQuery);

  while ($row = mysqli_fetch_assoc($barangayResult)) {
    $barangays[] = $row;
  }
} else {
  // Select the first station if none is selected
  $stationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
  $stationResult = mysqli_query($conn, $stationQuery);
  if ($stationRow = mysqli_fetch_assoc($stationResult)) {
    $selectedStation = $stationRow['stationID'];

    // Query barangays for this first station
    $barangayQuery = "SELECT * FROM barangay WHERE stationID = '$selectedStation' ORDER BY barangayName ASC";
    $barangayResult = mysqli_query($conn, $barangayQuery);

    while ($row = mysqli_fetch_assoc($barangayResult)) {
      $barangays[] = $row;
    }
  }
}

// For Barangay Selection (Only if a station is selected)
if ($selectedBarangay == 0 && !empty($barangays)) {
  $selectedBarangay = $barangays[0]['barangayID']; // Select the first barangay if none is selected
}

// Fetch patients if a barangay is selected
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

// Initialize prediction and comparison variables
$totalPredictions = count($patients);
$correctPredictions = 0;

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
              <div class="col-md-6">
                <select name="station" class="form-control" id="station" onchange="this.form.submit()">
                  <option value="0" disabled selected>Select Barangay Health Station</option>
                  <?php
                  $stationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
                  $stationResult = mysqli_query($conn, $stationQuery);

                  while ($row = mysqli_fetch_assoc($stationResult)) {
                    $stationID = $row['stationID'];
                    $stationName = $row['stationName'];
                    $selected = ($stationID == $selectedStation) ? 'selected' : '';

                    echo "<option value=\"$stationID\" $selected>$stationName</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
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
          <table class="table table-responsive text-center" style="<?php echo $selectedBarangay ? 'display:table;' : 'display:none;'; ?>">
            <thead>
              <tr>
                <th>Family Serial Number</th>
                <th>Name</th>
                <th>Risk Level</th>
                <th>Predicted Outcome</th>
                <th>Actual Outcome</th>
                <th>Probability</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($patients) > 0):
                $riskLevels = [
                  'Low Risk' => 0,
                  'High Risk' => 0,
                  'Pre-term' => 0,
                  'Fatal Death' => 0
                ];

                $monthlyCounts = [];
                foreach (range(1, 12) as $month) {
                  foreach (array_keys($riskLevels) as $risk) {
                    $monthlyCounts[$month][$risk] = 0;
                  }
                }

                foreach ($patients as $patient):
                  $riskLevel = 'Low Risk';
                  $predictedOutcome = 'Full term';
                  $actualOutcome = '-';
                  $probability = "--";

                  $patientID = $patient['patientID'];
                  $patientAge = $patient['patientAge'] ?? null;
                  $parity = $patient['pnParity'] ?? null;

                  $predictionRiskArr = array(
                    "age" => "low",
                    "parity" => "low",
                    "bmi" => "low",
                    "cbc" => "low",
                    "gestational" => "low",
                    "syphilis" => "low",
                    "hepatitis" => "low"
                  );

                  // AGE
                  if ($patientAge < 18 || $patientAge > 35) {
                    // $riskLevel = 'High Risk';
                    // $predictedOutcome = 'Pre-term';
                    $predictionRiskArr["age"] = "high";
                  }
                  // PARITY
                  if ($parity == 1 || $parity >= 5) {
                    // $riskLevel = 'High Risk';
                    // $predictedOutcome = 'Pre-term';
                    $predictionRiskArr["parity"] = "high";
                  }
                  // BMI
                  $bmi = $patient['patientBMI'] ?? null;
                  if ($bmi) {
                    if ($bmi < 18.5 || $bmi > 29.9) {
                      // $riskLevel = 'High Risk';
                      // $predictedOutcome = 'Pre-term';
                      $predictionRiskArr["bmi"] = "high";
                    }
                  }
                  // GESTATIONAL AND CBC
                  $labQuery = "SELECT gestationalResult, cbcHgbHctResult FROM laboratory WHERE patientID = '$patientID'";
                  $labResult = mysqli_query($conn, $labQuery);
                  $labData = mysqli_fetch_assoc($labResult);

                  if ($labData['cbcHgbHctResult'] == 1) {
                    // $riskLevel = 'High Risk';
                    // $predictedOutcome = 'Pre-term';
                    $predictionRiskArr["cbc"] = "high";
                  }

                  if ($labData['gestationalResult'] == 1) {
                    // $riskLevel = 'High Risk';
                    // $predictedOutcome = 'Pre-term';
                    $predictionRiskArr["gestational"] = "high";
                  }

                  // HEPATITIS AND SYPHILIS
                  $infectiousQuery = "SELECT hepatitisResult, syphilisResult FROM infectious WHERE patientID = '$patientID'";
                  $infectiousResult = mysqli_query($conn, $infectiousQuery);
                  $infectiousData = mysqli_fetch_assoc($infectiousResult);

                  if ($infectiousData['syphilisResult'] == 1) {
                    // $riskLevel = 'High Risk';
                    // $predictedOutcome = 'Pre-term';
                    $predictionRiskArr["syphilis"] = "high";
                  }

                  if ($infectiousData['hepatitisResult'] == 1) {
                    // $riskLevel = 'High Risk';
                    // $predictedOutcome = 'Fatal Death';
                    $predictionRiskArr["hepatitis"] = "high";
                  }

                  $lowCount = 0;
                  $highCount = 0;
                  foreach ($predictionRiskArr as $risk => $val) {
                    if ($val) {
                      if ($val == "low") {
                        $lowCount++;
                      } else {
                        $highCount++;
                      }
                    }
                  }

                  if (count($predictionRiskArr) == ($lowCount + $highCount)) {
                    if (count($predictionRiskArr) == $lowCount) {
                      $riskLevel = "Low Risk";
                      $predictedOutcome = "Full term";
                    } else if ($highCount >= 2 && $highCount < 3) {
                      $riskLevel = "High Risk";
                      $predictedOutcome = "Pre-term";
                    } else if ($highCount >= 3) {
                      $riskLevel = "High Risk";
                      $predictedOutcome = "Fatal Death";
                    }

                    $probabilityPercent = round((1 - ($highCount / count($predictionRiskArr))) * 100, 2);
                    $probability = "Full-term delivery: <strong>$probabilityPercent</strong>%";
                  } else {
                    $riskLevel = "--";
                    $predictedOutcome = "--";
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
                    $correctPredictions++;
                  }

                  if ($riskLevel == 'High Risk') {
                    $riskLevels['High Risk']++;
                  } elseif ($predictedOutcome == 'Pre-term') {
                    $riskLevels['Pre-term']++;
                  } elseif ($predictedOutcome == 'Fatal Death') {
                    $riskLevels['Fatal Death']++;
                  } else {
                    $riskLevels['Low Risk']++;
                  }
                  $monthlyCounts[$month][$riskLevel]++;
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
                    <td><?= $probability ?></td>
                  </tr>
                <?php endforeach;
                $accuracyRate = $totalPredictions > 0 ? ($correctPredictions / $totalPredictions) * 100 : 0;
                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $dataLowRisk = array_column($monthlyCounts, 'Low Risk');
                $dataHighRisk = array_column($monthlyCounts, 'High Risk');
                $dataPreTerm = array_column($monthlyCounts, 'Pre-term');
                $dataFatalDeath = array_column($monthlyCounts, 'Fatal Death'); ?>
              <?php else: ?>
                <tr>
                  <td colspan="5">No patients found for the selected barangay.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="card-body text-center">
          <h6>Comparison Summary</h6>
          <p>Total Patients: <?php echo $totalPredictions; ?></p>
          <p>Correct Predictions: <?php echo $correctPredictions; ?></p>
        </div>
        <canvas id="riskLevelChart"></canvas>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const riskLevelCtx = document.getElementById('riskLevelChart').getContext('2d');
  const riskLevelChart = new Chart(riskLevelCtx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
          label: 'Low Risk',
          data: <?php echo json_encode($dataLowRisk); ?>,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        },
        {
          label: 'High Risk',
          data: <?php echo json_encode($dataHighRisk); ?>,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        },
        {
          label: 'Pre-term',
          data: <?php echo json_encode($dataPreTerm); ?>,
          backgroundColor: 'rgba(255, 206, 86, 0.2)',
          borderColor: 'rgba(255, 206, 86, 1)',
          borderWidth: 1
        },
        {
          label: 'Fatal Death',
          data: <?php echo json_encode($dataFatalDeath); ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<?php
include('includes/footer.php');
?>