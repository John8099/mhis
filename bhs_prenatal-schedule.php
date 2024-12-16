<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
    header('Location: index.php');
    exit();
}
include('includes/header.php');
include('includes/midwife_navbar.php');

$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationName 
          FROM user u 
          LEFT JOIN station s ON u.stationID = s.stationID 
          WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

while ($user_data = mysqli_fetch_assoc($result)) {
    $stationName = $user_data['stationName'];
    $stationID = $user_data['stationID'];
}

$selectedBarangay = isset($_POST['barangay']) ? $_POST['barangay'] : 0;
$selectedPatientID = isset($_POST['patient']) ? $_POST['patient'] : 0;

$patients = []; 
$patientSerialNumber = ''; 

if ($selectedBarangay) {
    $patientQuery = "SELECT * FROM patient WHERE barangayID = '$selectedBarangay' ORDER BY patientFname ASC";
    $patientResult = mysqli_query($conn, $patientQuery);

    while ($row = mysqli_fetch_assoc($patientResult)) {
        $patients[] = $row;

        if ($row['patientID'] == $selectedPatientID) {
            $patientSerialNumber = $row['patientSerialNumber'];
            $selectedPatient = $row; 
        }
    }
}

if (isset($selectedPatientID)){
    $prenatalQuery = "SELECT p.*, prn.*
                      FROM patient p
                      LEFT JOIN `pre-natal_info` prn ON p.patientID = prn.patientID AND prn.isPosted = 0
                      WHERE p.patientID = '$selectedPatientID'";
    $prenatalResult = mysqli_query($conn, $prenatalQuery);

    if ($prenatalResult && mysqli_num_rows($prenatalResult) > 0) {
        $prenatalRow = mysqli_fetch_assoc($prenatalResult);
    } 
}
?>

<div class="container-fluid w-75">
    <div class="row my-3">
        <div class="col-lg-12">
            <a href="bhs_select-schedule-services.php" class="btn btn-primary mb-2"><i class="fa-solid fa-arrow-left"></i><span> Back</span></a>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Pre-natal Check-up Scheduling</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="barangay" class="form-label">Barangay</label>
                                <select name="barangay" class="form-control" id="barangay" onchange="this.form.submit()">
                                    <option value="0" disabled selected>Select Barangay</option>
                                    <?php
                                    $barangayQuery = "SELECT * FROM barangay WHERE isActive = 1 and stationID = '$stationID' ORDER BY barangayName ASC";
                                    $barangayResult = mysqli_query($conn, $barangayQuery);

                                    while ($row = mysqli_fetch_assoc($barangayResult)) {
                                        $barangayID = $row['barangayID'];
                                        $barangayName = $row['barangayName'];
                                        $selected = ($barangayID == $selectedBarangay) ? 'selected' : '';

                                        echo "<option value=\"$barangayID\" $selected>$barangayName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="patient" class="form-label">Patient</label>
                                <select name="patient" class="form-control" id="patient" onchange="this.form.submit()">
                                    <option value="0" disabled selected>Select Patient</option>
                                    <?php
                                    foreach ($patients as $row) {
                                        $patientID = $row['patientID'];
                                        $patientFname = $row['patientFname'];
                                        $patientMname = $row['patientMname'];
                                        $patientLname = $row['patientLname'];

                                        $fullName = trim("$patientFname $patientMname $patientLname");

                                        $selected = ($patientID == $selectedPatientID) ? 'selected' : ''; 
                                        echo "<option value=\"$patientID\" $selected>$fullName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Family Serial No.</label>
                                <input type="text" class="form-control" value="<?php echo $patientSerialNumber; ?>" placeholder="Patient's family serial number" readonly>
                            </div>
                        </div>
                    </form>
                    <form action="bhs-functions.php" method="POST" id="prenatalForm">
                        <input type="hidden" name="patientID" value="<?php echo isset($selectedPatient) ? htmlspecialchars($selectedPatient['patientID']) : ''; ?>">
                        <input type="hidden" name="pnID" value="<?php echo htmlspecialchars($prenatalRow['pnID'] ?? ''); ?>">
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="trimester1">1st Trimester</label>
                                <input type="date" id="trimester1" class="form-control" value="<?php echo $prenatalRow['pnTrimester1'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="trimester2">2nd Trimester</label>
                                <input type="date" id="trimester2" class="form-control" value="<?php echo $prenatalRow['pnTrimester2'] ?? ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="trimester3">3rd Trimester (1st Visit)</label>
                                <input type="date" id="trimester3" class="form-control" value="<?php echo $prenatalRow['pnTrimester3'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="trimester4">3rd Trimester (2nd Visit)</label>
                                <input type="date" id="trimester4" class="form-control" value="<?php echo $prenatalRow['pnTrimester4'] ?? ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" name="prenatalSchedule" id="submit_schedule" class="btn btn-primary" disabled>Schedule Check-up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateFields = [
            document.getElementById('trimester1'),
            document.getElementById('trimester2'),
            document.getElementById('trimester3'),
            document.getElementById('trimester4')
        ];
        const submitButton = document.getElementById('submit_schedule');

        function checkDateFields() {
            let hasValue = dateFields.some(field => field.value !== '');
            submitButton.disabled = !hasValue;
        }

        checkDateFields();

        dateFields.forEach(field => {
            field.addEventListener('change', checkDateFields);
        });
    });
</script>

<?php 
include 'includes/scripts.php';
?>
