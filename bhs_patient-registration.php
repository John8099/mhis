<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
  header('Location: index.php');
  exit();
}
include('includes/header.php');
include('includes/midwife_navbar.php');

$username = $_SESSION['user'];

function generateUniqueSerialNumber($conn)
{
  $serialNumber = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
  $numberQuery = "SELECT COUNT(*) FROM patient WHERE patientSerialNumber = '$serialNumber'";
  $numberResult = mysqli_query($conn, $numberQuery);
  $numberRow = mysqli_fetch_row($numberResult);
  if ($numberRow[0] > 0) {
    return generateUniqueSerialNumber($conn);
  }
  return $serialNumber;
}
$patientSerialNumber = generateUniqueSerialNumber($conn);

$query = "SELECT u.*, b.barangayName FROM user u LEFT JOIN station s ON u.stationID = s.stationID LEFT JOIN barangay b ON b.stationID = s.stationID WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $user_data = mysqli_fetch_assoc($result);
}
?>

<style>
  .checkbox-label {
    display: flex;
    align-items: center;
  }

  .checkbox-label input[type="checkbox"] {
    margin-right: 10px;
  }

  .btn {
    width: 10rem;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
</style>

<div class="container-fluid">
  <div class="row my-3">
    <div class="col-lg-12">
      <form method="post" action="bhs-functions.php">
        <div class="card shadow mb-4 mx-auto" id="page1">
          <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Target Client List</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="form-group col">
                <label for="patientSerialNumber">Family Serial No.</label>
                <input type="number" class="form-control" id="patientSerialNumber" name="patientSerialNumber" placeholder="Patient's family serial no." value="<?php echo $patientSerialNumber; ?>" readonly required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label>First Name</label>
                <input type="text" name="patientFirstName" class="form-control" placeholder="Patient's first name" required>
              </div>
              <div class="form-group col-md-4">
                <label>Middle Name</label>
                <input type="text" name="patientMiddleName" class="form-control" placeholder="Patient's middle name" required>
              </div>
              <div class="form-group col-md-4">
                <label>Last Name</label>
                <input type="text" name="patientLastName" class="form-control" placeholder="Patient's last name" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label>Birthday</label>
                <input type="date" name="patientBirthday" id="birthday" class="form-control" required>
              </div>
              <div class="form-group col-md-3">
                <label>Age</label>
                <input type="number" name="patientAge" id="age" class="form-control" placeholder="Patient's age" readonly required>
              </div>
              <div class="form-group col-md-3">
                <label>Weight (kg)</label>
                <input type="number" name="patientWeight" id="weight" class="form-control" placeholder="Patient's weight in kilograms" step="0.01" required>
              </div>
              <div class="form-group col-md-3">
                <label>Height (m)</label>
                <input type="number" name="patientHeight" id="height" class="form-control" placeholder="Patient's height in meters" step="0.01" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label>BMI Result</label>
                <input type="text" name="patientBMIResult" id="bmi" class="form-control" placeholder="Patient's BMI result" readonly required>
              </div>
              <div class="form-group col-md-4">
                <label>BMI Category</label>
                <input type="text" name="patientBMICategory" id="bmiCategory" class="form-control" placeholder="Patient's BMI category" readonly required>
              </div>
              <div class="form-group col-md-4">
                <label>Blood Type</label>
                <select name="patientBloodType" class="form-control" required>
                  <option disabled selected>Select blood type</option>
                  <option value="O+">O Positive</option>
                  <option value="O-">O Negative</option>
                  <option value="A+">A Positive</option>
                  <option value="A-">A Negative</option>
                  <option value="B+">B Positive</option>
                  <option value="B-">B Negative</option>
                  <option value="AB+">AB Positive</option>
                  <option value="AB-">AB Negative</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label for="patientBarangay">Barangay</label>
                <select name="patientBarangay" class="form-control" id="patientBarangay" onchange="toggleSubmitButton()" required>
                  <option value="0" disabled selected>Select Barangay</option>
                  <?php
                  $stationID = $user_data['stationID'];
                  $barangayQuery = "SELECT * FROM barangay WHERE isActive = 1 and stationID = '$stationID' ORDER BY barangayName ASC";
                  $barangayResult = mysqli_query($conn, $barangayQuery);

                  while ($row = mysqli_fetch_assoc($barangayResult)) {
                    $barangayID   = $row['barangayID'];
                    $barangayName = $row['barangayName'];

                    echo "<option value=\"$barangayID\">$barangayName</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label>Contact No.</label>
                <input type="number" name="patientContactNumber" class="form-control" maxlength="11" placeholder="Patient's contact number" oninput="validateNumberInput(this)">
              </div>
              <div class="form-group col-md-4">
                <label>Emergency Contact</label>
                <input type="number" name="patientEmergencyContact" maxlength="11" class="form-control" placeholder="Patient's emergency contact number" oninput="validateNumberInput(this)">
              </div>
            </div>
            <div class="form-group">
              <label>Socio Economic Status</label>
              <select name="patientSocioEconomicStatus" class="form-control" required>
                <option disabled selected>Select economic status</option>
                <option value="1">NHTS</option>
                <option value="0">Non-NHTS</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group text-right">
          <button type="submit" class="btn btn-success" id="submit" name="addPatient">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function calculateAge() {
    var birthday = new Date(document.getElementById('birthday').value);
    var today = new Date();
    var age = today.getFullYear() - birthday.getFullYear();

    if (today.getMonth() < birthday.getMonth() || (today.getMonth() == birthday.getMonth() && today.getDate() < birthday.getDate())) {
      age--;
    }
    document.getElementById('age').value = age;
  }
  document.getElementById('birthday').addEventListener('change', calculateAge);

  function calculateBMI() {
    var weight = parseFloat(document.getElementById('weight').value);
    var height = parseFloat(document.getElementById('height').value);
    if (weight && height) {
      var bmi = weight / (height * height);
      document.getElementById('bmi').value = bmi.toFixed(2);

      var bmiCategory = '';
      if (bmi < 18.5) {
        bmiCategory = 'Underweight';
      } else if (bmi >= 18.5 && bmi < 24.9) {
        bmiCategory = 'Normal';
      } else if (bmi >= 24.9 && bmi < 29.9) {
        bmiCategory = 'Overweight';
      } else {
        bmiCategory = 'Obese';
      }
      document.getElementById('bmiCategory').value = bmiCategory;
    } else {
      document.getElementById('bmi').value = '';
      document.getElementById('bmiCategory').value = '';
    }
  }
  document.getElementById('weight').addEventListener('input', calculateBMI);
  document.getElementById('height').addEventListener('input', calculateBMI);

  function validateNumberInput(input) {
    input.value = input.value.replace(/\D/g, '');
    if (input.value.length > 11) {
      input.value = input.value.slice(0, 11);
    }
  }

  function toggleSubmitButton() {
    var patientBarangay = document.getElementById('patientBarangay');
    var submitButton = document.getElementById('submit');

    if (patientBarangay.value === '0') {
      submitButton.disabled = true;
    } else {
      submitButton.disabled = false;
    }
  }
  document.addEventListener('DOMContentLoaded', function() {
    toggleSubmitButton();
  });
</script>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>