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

if (isset($selectedPatientID)) {
    $micronutrientQuery = "SELECT p.*, mic.*
                           FROM patient p
                           LEFT JOIN micronutrient_info mic ON p.patientID = mic.patientID AND mic.isPosted = 0
                           WHERE p.patientID = '$selectedPatientID';";
    $micronutrientResult = mysqli_query($conn, $micronutrientQuery);

    if ($micronutrientResult && mysqli_num_rows($micronutrientResult) > 0) {
        $micronutrientRow = mysqli_fetch_assoc($micronutrientResult);
    } 
}
?>

<div class="container-fluid w-75">
    <div class="row my-3">
        <div class="col-lg-12">
            <a href="bhs_select-schedule-other-services.php" class="btn btn-primary mb-2"><i class="fa-solid fa-arrow-left"></i><span> Back</span></a>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Iron Sulfate with Folic Acid Check-up Scheduling</h5>
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
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($patientSerialNumber); ?>" placeholder="Patient's family serial number" readonly>
                            </div>
                        </div>
                    </form>
                    <form action="bhs-functions.php" method="POST" id="micronutrientForm">
                        <input type="hidden" name="patientID" value="<?php echo isset($selectedPatient) ? htmlspecialchars($selectedPatient['patientID']) : ''; ?>">
                        <input type="hidden" name="ironID" value="<?php echo htmlspecialchars($micronutrientRow['ironID'] ?? ''); ?>">
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="iron_1st_tri_date">1st Trimester Check-up Date</label>
                                <input type="date" class="form-control" name="iron_1st_tri_date" id="iron_1st_tri_date" value="<?php echo htmlspecialchars($micronutrientRow['ironDate1'] ?? ''); ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="iron_1st_tri_num">Number of Tablet/s</label>
                                <input type="number" class="form-control" name="iron_1st_tri_num" id="iron_1st_tri_num" value="<?php echo htmlspecialchars($micronutrientRow['ironNum1'] ?? '0'); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="iron_2nd_tri_date">2nd Trimester Check-up Date</label>
                                <input type="date" class="form-control" name="iron_2nd_tri_date" id="iron_2nd_tri_date" value="<?php echo htmlspecialchars($micronutrientRow['ironDate2'] ?? ''); ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="iron_2nd_tri_num">Number of Tablet/s</label>
                                <input type="number" class="form-control" name="iron_2nd_tri_num" id="iron_2nd_tri_num" value="<?php echo htmlspecialchars($micronutrientRow['ironNum2'] ?? '0'); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="iron_3rd_tri_date">3rd Trimester (1st Visit) Check-up Date</label>
                                <input type="date" class="form-control" name="iron_3rd_tri_date" id="iron_3rd_tri_date" value="<?php echo htmlspecialchars($micronutrientRow['ironDate3'] ?? ''); ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="iron_3rd_tri_num">Number of Tablet/s</label>
                                <input type="number" class="form-control" name="iron_3rd_tri_num" id="iron_3rd_tri_num" value="<?php echo htmlspecialchars($micronutrientRow['ironNum3'] ?? '0'); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="iron_4th_tri_date">3rd Trimester (2nd Visit) Check-up Date</label>
                                <input type="date" class="form-control" name="iron_4th_tri_date" id="iron_4th_tri_date" value="<?php echo htmlspecialchars($micronutrientRow['ironDate4'] ?? ''); ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="iron_4th_tri_num">Number of Tablet/s</label>
                                <input type="number" class="form-control" name="iron_4th_tri_num" id="iron_4th_tri_num" value="<?php echo htmlspecialchars($micronutrientRow['ironNum4'] ?? '0'); ?>" readonly>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" name="micronutrientSchedule" id="submit_schedule" class="btn btn-primary" disabled>Schedule Check-up</button>
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
            document.getElementById('iron_1st_tri_date'),
            document.getElementById('iron_2nd_tri_date'),
            document.getElementById('iron_3rd_tri_date'),
            document.getElementById('iron_4th_tri_date')
        ];
        
        const tabletFields = [
            document.getElementById('iron_1st_tri_num'),
            document.getElementById('iron_2nd_tri_num'),
            document.getElementById('iron_3rd_tri_num'),
            document.getElementById('iron_4th_tri_num')
        ];
        
        const submitButton = document.getElementById('submit_schedule');

        function checkFields() {
            let dateValid = dateFields.every(field => field.value !== '');

            let tabletValid = tabletFields.every(field => field.value !== '' && field.value !== '0');
            
            submitButton.disabled = !(dateValid && tabletValid);
        }

        checkFields();

        [...dateFields, ...tabletFields].forEach(field => {
            field.addEventListener('change', checkFields);
        });
    });
</script>

<?php 
include 'includes/scripts.php';
?>
