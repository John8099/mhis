<?php
session_start();
require './class/class_bhs.php';
$classBHS = new BHS;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  switch (true) {
    case isset($_POST['addPatient']):
      addPatient($classBHS);
      break;
    case isset($_POST['updatePatient']):
      updatePatient($classBHS);
      break;
    case isset($_POST['prenatalSchedule']):
      setPrenatalSchedule($classBHS);
      break;
    case isset($_POST['dewormingSchedule']):
      setDewormingSchedule($classBHS);
      break;
    case isset($_POST['tetanusSchedule']):
      setTetanusSchedule($classBHS);
      break;
    case isset($_POST['calciumSchedule']):
      setCalciumSchedule($classBHS);
      break;
    case isset($_POST['iodineSchedule']):
      setIodineSchedule($classBHS);
      break;
    case isset($_POST['micronutrientSchedule']):
      setMicronutrientSchedule($classBHS);
      break;
    case isset($_POST['updatePatientSchedule']):
      updatePatientSched($classBHS);
      break;
    default:
      echo "<script>alert('Invalid action.');window.location.href='index';</script>";
      break;
  }
}

function addPatient($classBHS)
{
  $patientSerialNumber = $_POST['patientSerialNumber'];
  $patientFirstName = $_POST['patientFirstName'];
  $patientMiddleName = $_POST['patientMiddleName'];
  $patientLastName = $_POST['patientLastName'];
  $patientBirthday = $_POST['patientBirthday'];
  $patientAge = $_POST['patientAge'];
  $patientWeight = $_POST['patientWeight'];
  $patientHeight = $_POST['patientHeight'];
  $patientBMIResult = $_POST['patientBMIResult'];
  $patientBMICategory = $_POST['patientBMICategory'];
  $patientBloodType = $_POST['patientBloodType'];
  $patientBarangay = $_POST['patientBarangay'];
  $patientContactNumber = !empty($_POST['patientContactNumber']) ? $_POST['patientContactNumber'] : null;
  $patientEmergencyContact = !empty($_POST['patientEmergencyContact']) ? $_POST['patientEmergencyContact'] : null;
  $patientSocioEconomicStatus = $_POST['patientSocioEconomicStatus'];

  $result = $classBHS->addPatient(
    $patientSerialNumber,
    $patientFirstName,
    $patientMiddleName,
    $patientLastName,
    $patientBirthday,
    $patientAge,
    $patientWeight,
    $patientHeight,
    $patientBMIResult,
    $patientBMICategory,
    $patientBloodType,
    $patientBarangay,
    $patientContactNumber,
    $patientEmergencyContact,
    $patientSocioEconomicStatus
  );

  if ($result) {
    $patientID = $result;
    header("Location: bhs_patient-edit?id=$patientID");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-registration';</script>";
  }
}

function updatePatient($classBHS)
{
  $poPlaceType = $_POST['poPlaceType'] === "Others" && !empty($_POST['other_poPlaceType']) ? $_POST['other_poPlaceType'] : $_POST['poPlaceType'];
  $poBirthAttendant = $_POST['poBirthAttendant'] === "O" && !empty($_POST['other_poBirthAttendant']) ? $_POST['other_poBirthAttendant'] : $_POST['poBirthAttendant'];
  $patientData = [
    // PATIENT
    'patientID' => $_POST['patientID'],
    'patientSerialNumber' => !empty($_POST['patientSerialNumber']) ? $_POST['patientSerialNumber'] : null,
    'patientFname' => !empty($_POST['patientFname']) ? $_POST['patientFname'] : null,
    'patientMname' => !empty($_POST['patientMname']) ? $_POST['patientMname'] : null,
    'patientLname' => !empty($_POST['patientLname']) ? $_POST['patientLname'] : null,
    'patientBirthday' => !empty($_POST['patientBirthday']) ? $_POST['patientBirthday'] : null,
    'patientAge' => !empty($_POST['patientAge']) ? $_POST['patientAge'] : null,
    'patientWeight' => !empty($_POST['patientWeight']) ? $_POST['patientWeight'] : null,
    'patientHeight' => !empty($_POST['patientHeight']) ? $_POST['patientHeight'] : null,
    'patientBMI' => !empty($_POST['patientBMI']) ? $_POST['patientBMI'] : null,
    'patientBMICategory' => !empty($_POST['patientBMICategory']) ? $_POST['patientBMICategory'] : null,
    'patientBloodType' => !empty($_POST['patientBloodType']) ? $_POST['patientBloodType'] : null,
    'patientBarangay' => !empty($_POST['patientBarangay']) ? $_POST['patientBarangay'] : null,
    'patientContactNumber' => !empty($_POST['patientContactNumber']) ? $_POST['patientContactNumber'] : null,
    'patientEmergencyContact' => !empty($_POST['patientEmergencyContact']) ? $_POST['patientEmergencyContact'] : null,
    'patientNHTS' => !empty($_POST['patientNHTS']) ? $_POST['patientNHTS'] : null,

    // PRE-NATAL
    'pnLMP' => !empty($_POST['pnLMP']) ? $_POST['pnLMP'] : null,
    'pnGravidity' => !empty($_POST['pnGravidity']) ? $_POST['pnGravidity'] : null,
    'pnParity' => !empty($_POST['pnParity']) ? $_POST['pnParity'] : null,
    'pnEDC' => !empty($_POST['pnEDC']) ? $_POST['pnEDC'] : null,
    'pnTrimester1' => !empty($_POST['pnTrimester1']) ? $_POST['pnTrimester1'] : null,
    'pnTrimester2' => !empty($_POST['pnTrimester2']) ? $_POST['pnTrimester2'] : null,
    'pnTrimester3' => !empty($_POST['pnTrimester3']) ? $_POST['pnTrimester3'] : null,
    'pnTrimester4' => !empty($_POST['pnTrimester4']) ? $_POST['pnTrimester4'] : null,

    // TETANUS
    'tt1' => !empty($_POST['tt1']) ? $_POST['tt1'] : null,
    'tt2' => !empty($_POST['tt2']) ? $_POST['tt2'] : null,
    'tt3' => !empty($_POST['tt3']) ? $_POST['tt3'] : null,
    'tt4' => !empty($_POST['tt4']) ? $_POST['tt4'] : null,
    'tt5' => !empty($_POST['tt5']) ? $_POST['tt5'] : null,
    'ttFIM' => !empty($_POST['ttFIM']) ? $_POST['ttFIM'] : null,

    // MICRONUTRIENT
    'ironNum1' => !empty($_POST['ironNum1']) ? $_POST['ironNum1'] : null,
    'ironDate1' => !empty($_POST['ironDate1']) ? $_POST['ironDate1'] : null,
    'ironNum2' => !empty($_POST['ironNum2']) ? $_POST['ironNum2'] : null,
    'ironDate2' => !empty($_POST['ironDate2']) ? $_POST['ironDate2'] : null,
    'ironNum3' => !empty($_POST['ironNum3']) ? $_POST['ironNum3'] : null,
    'ironDate3' => !empty($_POST['ironDate3']) ? $_POST['ironDate3'] : null,
    'ironNum4' => !empty($_POST['ironNum4']) ? $_POST['ironNum4'] : null,
    'ironDate4' => !empty($_POST['ironDate4']) ? $_POST['ironDate4'] : null,

    // CALCIUM
    'calNum1' => !empty($_POST['calNum1']) ? $_POST['calNum1'] : null,
    'calDate1' => !empty($_POST['calDate1']) ? $_POST['calDate1'] : null,
    'calNum2' => !empty($_POST['calNum2']) ? $_POST['calNum2'] : null,
    'calDate2' => !empty($_POST['calDate2']) ? $_POST['calDate2'] : null,
    'calNum3' => !empty($_POST['calNum3']) ? $_POST['calNum3'] : null,
    'calDate3' => !empty($_POST['calDate3']) ? $_POST['calDate3'] : null,
    'iodTablet' => !empty($_POST['iodTablet']) ? $_POST['iodTablet'] : null,
    'iodDate' => !empty($_POST['iodDate']) ? $_POST['iodDate'] : null,
    'nutritionalAssessment' => !empty($_POST['nutritionalAssessment']) ? $_POST['nutritionalAssessment'] : null,

    // DEWORMING
    'dwDate' => !empty($_POST['dwDate']) ? $_POST['dwDate'] : null,
    'dwTablet' => !empty($_POST['dwTablet']) ? $_POST['dwTablet'] : null,

    // INFECTIOUS
    'syphilisDate' => !empty($_POST['syphilisDate']) ? $_POST['syphilisDate'] : null,
    'syphilisResult' => !empty($_POST['syphilisResult']) ? $_POST['syphilisResult'] : null,
    'hepatitisDate' => !empty($_POST['hepatitisDate']) ? $_POST['hepatitisDate'] : null,
    'hepatitisResult' => !empty($_POST['hepatitisResult']) ? $_POST['hepatitisResult'] : null,
    'hivScreeningDate' => !empty($_POST['hivScreeningDate']) ? $_POST['hivScreeningDate'] : null,

    // LABORATORY
    'gestationalDate' => !empty($_POST['gestationalDate']) ? $_POST['gestationalDate'] : null,
    'gestationalResult' => !empty($_POST['gestationalResult']) ? $_POST['gestationalResult'] : null,
    'cbcHgbHctDate' => !empty($_POST['cbcHgbHctDate']) ? $_POST['cbcHgbHctDate'] : null,
    'cbcHgbHctResult' => !empty($_POST['cbcHgbHctResult']) ? $_POST['cbcHgbHctResult'] : null,
    'cbcHgbHctIron' => !empty($_POST['cbcHgbHctIron']) ? $_POST['cbcHgbHctIron'] : null,

    // OUTCOME
    'poTerminatedDate' => !empty($_POST['poTerminatedDate']) ? $_POST['poTerminatedDate'] : null,
    'poOutcome' => !empty($_POST['poOutcome']) ? $_POST['poOutcome'] : null,
    'poBabySex' => !empty($_POST['poBabySex']) ? $_POST['poBabySex'] : null,
    'poBabyWeight' => !empty($_POST['poBabyWeight']) ? $_POST['poBabyWeight'] : null,
    'poDeliveryType' => !empty($_POST['poDeliveryType']) ? $_POST['poDeliveryType'] : null,
    'poPlaceType' => $poPlaceType,
    'poBirthAttendant' => $poBirthAttendant,
    'poDeliveryDate' => !empty($_POST['poDeliveryDate']) ? $_POST['poDeliveryDate'] : null,
    'poDeliveryTime' => !empty($_POST['poDeliveryTime']) ? $_POST['poDeliveryTime'] : null
  ];
  $result = $classBHS->updatePatient($patientData);

  if ($result) {
    header("Location: bhs_patient-records");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function setPrenatalSchedule($classBHS)
{
  $pnID = $_POST['pnID'];
  $patientID = $_POST['patientID'];

  $result = $classBHS->setPrenatalSchedule($pnID, $patientID);

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function setDewormingSchedule($classBHS)
{
  $dwID = $_POST['dwID'];
  $patientID = $_POST['patientID'];

  $result = $classBHS->setDewormingSchedule($dwID, $patientID);

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function setTetanusSchedule($classBHS)
{
  $ttID = $_POST['ttID'];
  $patientID = $_POST['patientID'];

  $result = $classBHS->setTetanusSchedule($ttID, $patientID);

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function setCalciumSchedule($classBHS)
{
  $calID = $_POST['calID'];
  $patientID = $_POST['patientID'];

  $result = $classBHS->setCalciumSchedule($calID, $patientID);

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function setIodineSchedule($classBHS)
{
  $iodineID = $_POST['iodineID'];
  $patientID = $_POST['patientID'];
  $checkup_date = $_POST['checkup_date'];

  $result = $classBHS->setIodineSchedule($iodineID, $patientID, $checkup_date);

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function setMicronutrientSchedule($classBHS)
{
  $ironID = $_POST['ironID'];
  $patientID = $_POST['patientID'];

  $result = $classBHS->setMicronutrientSchedule($ironID, $patientID);

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_patient-edit';</script>";
  }
}

function updatePatientSched($classBHS)
{
  $scheduleID = $_POST['modalScheduleID'];
  $scheduleDate = $_POST['modalScheduleDate'];
  $scheduleStatus = $_POST['modalScheduleStatus'];
  $scheduleType = $_POST['modalScheduleType'];

  $stationId = $_POST["stationId"];

  if ($scheduleStatus == "Reschedule") {
    $scheduleDate = $_POST["modalRescheduleDate"];
    $scheduleStatus = "Pending";
  }

  if ($scheduleStatus == "Completed") {
    $checkAvailability = $classBHS->checkAvailability($scheduleID, $stationId, $scheduleType);
    if (!$checkAvailability) {
      $result = $classBHS->updatePatientSched($scheduleID, $scheduleDate, $scheduleStatus, $scheduleType, $stationId);
    } else {
      echo "<script>alert('$checkAvailability');window.location.href='./bhs_scheduled-patients';</script>";
      exit();
    }
  } else {
    $result = $classBHS->updatePatientSched($scheduleID, $scheduleDate, $scheduleStatus, $scheduleType, $stationId);
  }

  if ($result) {
    header("Location: bhs_scheduled-patients");
  } else {
    echo "<script>alert('An error occurred. Please try again.');window.location.href='./bhs_scheduled-patients';</script>";
  }
}
