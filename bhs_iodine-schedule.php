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
  $iodineQuery = "SELECT p.*, i.iodID, i.iodTablet, i.iodDate
            FROM patient p
            LEFT JOIN iodine_info i ON p.patientID = i.patientID
            WHERE p.patientID = '$selectedPatientID';";
  $iodineResult = mysqli_query($conn, $iodineQuery);

  if ($iodineResult && mysqli_num_rows($iodineResult) > 0) {
    $iodineRow = mysqli_fetch_assoc($iodineResult);
  }
}
?>

<div class="container-fluid w-75">
  <div class="row my-3">
    <div class="col-lg-12">
      <a href="bhs_select-schedule-other-services.php" class="btn btn-primary mb-2"><i class="fa-solid fa-arrow-left"></i><span> Back</span></a>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">Iodine Capsule Check-up Scheduling</h5>
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
                  foreach ($patients as $patient) {
                    $patientID = $patient['patientID'];
                    $patientFname = $patient['patientFname'];
                    $patientMname = $patient['patientMname'];
                    $patientLname = $patient['patientLname'];

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
          <form action="bhs-functions.php" method="POST">
            <input type="hidden" name="patientID" value="<?php echo $selectedPatientID ?? ""; ?>">
            <input type="hidden" name="iodineID" value="<?php echo $iodineRow['iodID'] ?? ""; ?>">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="checkup_date">Check-up Date</label>
                <input type="date" class="form-control" name="checkup_date" id="checkup_date" value="<?php echo $iodineRow['iodDate'] ?? ''; ?>" <?= isset($iodineRow['iodDate']) ? "readonly" : "" ?>>
              </div>
              <div class="form-group col-md-6">
                <label for="checkup_date">Number of Tablets</label>
                <input type="number" class="form-control" name="checkup_num" id="checkup_num" value="<?php echo $iodineRow['iodTablet'] ?? '0'; ?>" <?= isset($iodineRow['iodTablet']) ? "readonly" : "" ?>>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" name="iodineSchedule" id="submit_schedule" class="btn btn-primary" <?php echo empty($iodineRow['iodDate']) || $iodineRow['iodDate'] === '0000-00-00' ? 'disabled' : ''; ?>>Schedule Check-up</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include 'includes/scripts.php';
include('includes/footer.php');
?>