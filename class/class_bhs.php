<?php
require './database/dbconfig.php';

if (!class_exists('BHS')) {
  class BHS
  {
    // Patient Registration
    public function addPatient($patientSerialNumber, $patientFirstName, $patientMiddleName, $patientLastName, $patientBirthday, $patientAge, $patientWeight, $patientHeight, $patientBMIResult, $patientBMICategory, $patientBloodType, $patientBarangay, $patientContactNumber, $patientEmergencyContact, $patientSocioEconomicStatus)
    {
      global $conn;

      $query = "SELECT * FROM patient WHERE patientSerialNumber = '$patientSerialNumber' AND patientFname = '$patientFirstName' AND patientMname = '$patientMiddleName' AND patientLname = '$patientLastName'";
      $result = mysqli_query($conn, $query);

      if ($result->num_rows > 0) {
        echo "<script>alert('Patient already exists.');window.location.href='./bhs_patient-registration';</script>";
      } else {
        $query = "INSERT INTO patient(barangayID, patientSerialNumber, registrationDate, patientFname, patientMname, patientLname, patientBirthday, patientAge, patientWeight, patientHeight, patientBMI, patientBMICategory, patientBloodType, patientContactNumber, patientEmergencyContact, patientNHTS)
                              VALUES('$patientBarangay', '$patientSerialNumber', CURDATE(), '$patientFirstName', '$patientMiddleName', '$patientLastName', '$patientBirthday', '$patientAge', '$patientWeight', '$patientHeight', '$patientBMIResult', '$patientBMICategory', '$patientBloodType', '$patientContactNumber', '$patientEmergencyContact', '$patientSocioEconomicStatus')";
        $result = mysqli_query($conn, $query);

        if ($result) {
          $lastPatientID = mysqli_insert_id($conn);
          return $lastPatientID;
        } else {
          return false;
        }
      }
    }

    public function updatePatient($patientData)
    {
      global $conn;

      $patientID = $patientData['patientID'];

      // PATIENT
      $patientSerialNumber = $patientData['patientSerialNumber'];
      $patientFname = $patientData['patientFname'];
      $patientMname = $patientData['patientMname'];
      $patientLname = $patientData['patientLname'];
      $patientBirthday = $patientData['patientBirthday'];
      $patientAge = $patientData['patientAge'];
      $patientWeight = $patientData['patientWeight'];
      $patientHeight = $patientData['patientHeight'];
      $patientBMI = $patientData['patientBMI'];
      $patientBMICategory = $patientData['patientBMICategory'];
      $patientBloodType = $patientData['patientBloodType'];
      $patientBarangay = $patientData['patientBarangay'];
      $patientContactNumber = $patientData['patientContactNumber'];
      $patientEmergencyContact = $patientData['patientEmergencyContact'];
      $patientNHTS = $patientData['patientNHTS'];

      $queryPatient = "UPDATE patient 
                        SET 
                            barangayID = " . ($patientBarangay ? "'$patientBarangay'" : "NULL") . ",
                            patientSerialNumber = " . ($patientSerialNumber ? "'$patientSerialNumber'" : "NULL") . ",
                            patientFname = " . ($patientFname ? "'$patientFname'" : "NULL") . ",
                            patientMname = " . ($patientMname ? "'$patientMname'" : "NULL") . ",
                            patientLname = " . ($patientLname ? "'$patientLname'" : "NULL") . ",
                            patientBirthday = " . ($patientBirthday ? "'$patientBirthday'" : "NULL") . ",
                            patientAge = " . ($patientAge ? "'$patientAge'" : "NULL") . ",
                            patientWeight = " . ($patientWeight ? "'$patientWeight'" : "NULL") . ",
                            patientHeight = " . ($patientHeight ? "'$patientHeight'" : "NULL") . ",
                            patientBMI = " . ($patientBMI ? "'$patientBMI'" : "NULL") . ",
                            patientBMICategory = " . ($patientBMICategory ? "'$patientBMICategory'" : "NULL") . ",
                            patientBloodType = " . ($patientBloodType ? "'$patientBloodType'" : "NULL") . ",
                            patientContactNumber = " . ($patientContactNumber ? "'$patientContactNumber'" : "NULL") . ",
                            patientEmergencyContact = " . ($patientEmergencyContact ? "'$patientEmergencyContact'" : "NULL") . ",
                            patientNHTS = " . ($patientNHTS ? "'$patientNHTS'" : "NULL") . "
                        WHERE patientID = '$patientID'";
      $resultPatient = mysqli_query($conn, $queryPatient);

      // PRE-NATAL
      $pnLMP = $patientData['pnLMP'];
      $pnGravidity = $patientData['pnGravidity'];
      $pnParity = $patientData['pnParity'];
      $pnEDC = $patientData['pnEDC'];
      $pnTrimester1 = $patientData['pnTrimester1'];
      $pnTrimester2 = $patientData['pnTrimester2'];
      $pnTrimester3 = $patientData['pnTrimester3'];
      $pnTrimester4 = $patientData['pnTrimester4'];

      $queryPrenatal = "UPDATE `pre-natal_info`
                        SET 
                            pnLMP = " . ($pnLMP ? "'$pnLMP'" : "NULL") . ",
                            pnGravidity = " . ($pnGravidity ? "'$pnGravidity'" : "NULL") . ",
                            pnParity = " . ($pnParity ? "'$pnParity'" : "NULL") . ",
                            pnEDC = " . ($pnEDC ? "'$pnEDC'" : "NULL") . ",
                            pnTrimester1 = " . ($pnTrimester1 ? "'$pnTrimester1'" : "NULL") . ",
                            pnTrimester2 = " . ($pnTrimester2 ? "'$pnTrimester2'" : "NULL") . ",
                            pnTrimester3 = " . ($pnTrimester3 ? "'$pnTrimester3'" : "NULL") . ",
                            pnTrimester4 = " . ($pnTrimester4 ? "'$pnTrimester4'" : "NULL") . "
                        WHERE patientID = '$patientID'";

      $resultPrenatal = mysqli_query($conn, $queryPrenatal);

      // TETANUS
      $tt1 = $patientData['tt1'];
      $tt2 = $patientData['tt2'];
      $tt3 = $patientData['tt3'];
      $tt4 = $patientData['tt4'];
      $tt5 = $patientData['tt5'];
      $ttFIM = $patientData['ttFIM'];

      $queryTetanus = "UPDATE tetanus_info 
                                SET 
                                    tt1 = " . ($tt1 ? "'$tt1'" : "NULL") . ",
                                    tt2 = " . ($tt2 ? "'$tt2'" : "NULL") . ",
                                    tt3 = " . ($tt3 ? "'$tt3'" : "NULL") . ",
                                    tt4 = " . ($tt4 ? "'$tt4'" : "NULL") . ",
                                    tt5 = " . ($tt5 ? "'$tt5'" : "NULL") . ",
                                    ttFIM = " . ($ttFIM ? "'$ttFIM'" : "NULL") . "
                                WHERE patientID = '$patientID'";
      $resultTetanus = mysqli_query($conn, $queryTetanus);

      // MICRONUTRIENT
      $ironNum1 = $patientData['ironNum1'];
      $ironDate1 = $patientData['ironDate1'];
      $ironNum2 = $patientData['ironNum2'];
      $ironDate2 = $patientData['ironDate2'];
      $ironNum3 = $patientData['ironNum3'];
      $ironDate3 = $patientData['ironDate3'];
      $ironNum4 = $patientData['ironNum4'];
      $ironDate4 = $patientData['ironDate4'];

      $queryMicronutrient = "UPDATE micronutrient_info 
                                       SET 
                                        ironNum1 = " . ($ironNum1 ? "'$ironNum1'" : "NULL") . ",
                                        ironDate1 = " . ($ironDate1 ? "'$ironDate1'" : "NULL") . ",
                                        ironNum2 = " . ($ironNum2 ? "'$ironNum2'" : "NULL") . ",
                                        ironDate2 = " . ($ironDate2 ? "'$ironDate2'" : "NULL") . ",
                                        ironNum3 = " . ($ironNum3 ? "'$ironNum3'" : "NULL") . ",
                                        ironDate3 = " . ($ironDate3 ? "'$ironDate3'" : "NULL") . ",
                                        ironNum4 = " . ($ironNum4 ? "'$ironNum4'" : "NULL") . ",
                                        ironDate4 = " . ($ironDate4 ? "'$ironDate4'" : "NULL") . "
                                       WHERE patientID = '$patientID'";

      $resultMicronutrient = mysqli_query($conn, $queryMicronutrient);

      // CALCIUM
      $calNum1 = $patientData['calNum1'];
      $calDate1 = $patientData['calDate1'];
      $calNum2 = $patientData['calNum2'];
      $calDate2 = $patientData['calDate2'];
      $calNum3 = $patientData['calNum3'];
      $calDate3 = $patientData['calDate3'];
      $iodNum = $patientData['iodNum'];
      $iodDate = $patientData['iodDate'];
      $nutritionalAssessment = $patientData['nutritionalAssessment'];

      // Update Query
      $queryCalcium = "UPDATE calcium_info
                                SET 
                                    calNum1 = " . ($calNum1 ? "'$calNum1'" : "NULL") . ", 
                                    calDate1 = " . ($calDate1 ? "'$calDate1'" : "NULL") . ", 
                                    calNum2 = " . ($calNum2 ? "'$calNum2'" : "NULL") . ", 
                                    calDate2 = " . ($calDate2 ? "'$calDate2'" : "NULL") . ", 
                                    calNum3 = " . ($calNum3 ? "'$calNum3'" : "NULL") . ", 
                                    calDate3 = " . ($calDate3 ? "'$calDate3'" : "NULL") . ", 
                                    nutritionalAssessment = " . ($nutritionalAssessment ? "'$nutritionalAssessment'" : "NULL") . " 
                                WHERE patientID = '$patientID'";
      $resultCalcium = mysqli_query($conn, $queryCalcium);

      // DEWORMING
      $dwDate = $patientData['dwDate'];
      $dwTablet = $patientData['dwTablet'];

      $queryDeworming = "UPDATE deworming_info 
                                SET 
                                    dwDate = " . ($dwDate ? "'$dwDate'" : "NULL") . ",
                                    dwTablet = " . ($dwTablet ? "'$dwTablet'" : "NULL") . " 
                                WHERE patientID = '$patientID'";
      $resultDeworming = mysqli_query($conn, $queryDeworming);

      // INFECTIOUS
      $syphilisDate = $patientData['syphilisDate'];
      $syphilisResult = $patientData['syphilisResult'];
      $hepatitisDate = $patientData['hepatitisDate'];
      $hepatitisResult = $patientData['hepatitisResult'];
      $hivScreeningDate = $patientData['hivScreeningDate'];

      $queryInfectious = "UPDATE infectious 
                                    SET 
                                        syphilisDate = " . ($syphilisDate ? "'$syphilisDate'" : "NULL") . ", 
                                        syphilisResult = " . ($syphilisResult ? "'$syphilisResult'" : "NULL") . ", 
                                        hepatitisDate = " . ($hepatitisDate ? "'$hepatitisDate'" : "NULL") . ", 
                                        hepatitisResult = " . ($hepatitisResult ? "'$hepatitisResult'" : "NULL") . ", 
                                        hivScreeningDate = " . ($hivScreeningDate ? "'$hivScreeningDate'" : "NULL") . " 
                                    WHERE patientID = '$patientID'";
      $resultInfectious = mysqli_query($conn, $queryInfectious);

      // LABORATORY
      $gestationalDate = $patientData['gestationalDate'];
      $gestationalResult = $patientData['gestationalResult'];
      $cbcHgbHctDate = $patientData['cbcHgbHctDate'];
      $cbcHgbHctResult = $patientData['cbcHgbHctResult'];
      $cbcHgbHctIron = $patientData['cbcHgbHctIron'];

      $queryLaboratory = "UPDATE laboratory 
                                    SET 
                                        gestationalDate = " . ($gestationalDate ? "'$gestationalDate'" : "NULL") . ", 
                                        gestationalResult = " . ($gestationalResult ? "'$gestationalResult'" : "NULL") . ", 
                                        cbcHgbHctDate = " . ($cbcHgbHctDate ? "'$cbcHgbHctDate'" : "NULL") . ", 
                                        cbcHgbHctResult = " . ($cbcHgbHctResult ? "'$cbcHgbHctResult'" : "NULL") . ", 
                                        cbcHgbHctIron = " . ($cbcHgbHctIron ? "'$cbcHgbHctIron'" : "NULL") . " 
                                    WHERE patientID = '$patientID'";
      $resultLaboratory = mysqli_query($conn, $queryLaboratory);

      // OUTCOME
      $poTerminatedDate = $patientData['poTerminatedDate'];
      $poOutcome = $patientData['poOutcome'];
      $poBabySex = $patientData['poBabySex'];
      $poBabyWeight = $patientData['poBabyWeight'];
      $poDeliveryType = $patientData['poDeliveryType'];
      $poPlaceType = $patientData['poPlaceType'];
      $poBirthAttendant = $patientData['poBirthAttendant'];
      $poDeliveryDate = $patientData['poDeliveryDate'];
      $poDeliveryTime = $patientData['poDeliveryTime'];

      $queryOutcome = "UPDATE pregnancy_outcome 
                                 SET 
                                    poTerminatedDate = " . ($poTerminatedDate ? "'$poTerminatedDate'" : "NULL") . ",
                                    poOutcome = " . ($poOutcome ? "'$poOutcome'" : "NULL") . ",
                                    poBabySex = " . ($poBabySex ? "'$poBabySex'" : "NULL") . ",
                                    poBabyWeight = " . ($poBabyWeight ? "'$poBabyWeight'" : "NULL") . ",
                                    poDeliveryType = " . ($poDeliveryType ? "'$poDeliveryType'" : "NULL") . ",
                                    poPlaceType = " . ($poPlaceType ? "'$poPlaceType'" : "NULL") . ",
                                    poBirthAttendant = " . ($poBirthAttendant ? "'$poBirthAttendant'" : "NULL") . ",
                                    poDeliveryDate = " . ($poDeliveryDate ? "'$poDeliveryDate'" : "NULL") . ",
                                    poDeliveryTime = " . ($poDeliveryTime ? "'$poDeliveryTime'" : "NULL") . "
                                 WHERE patientID = '$patientID'";
      $resultOutcome = mysqli_query($conn, $queryOutcome);

      if ($resultPatient && $resultPrenatal && $resultTetanus && $resultMicronutrient && $resultCalcium && $resultDeworming && $resultInfectious && $resultLaboratory && $resultOutcome) {
        return true;
      } else {
        return false;
      }
    }

    public function setPrenatalSchedule($pnID, $patientID)
    {
      global $conn;

      $query = "UPDATE `pre-natal_info` 
                          SET isPosted = 1
                          WHERE pnID = $pnID AND patientID = $patientID";
      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function setDewormingSchedule($dwID, $patientID)
    {
      global $conn;

      $query = "UPDATE deworming_info
                          SET isPosted = 1
                          WHERE dwID = $dwID AND patientID = $patientID";
      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function setTetanusSchedule($ttID, $patientID)
    {
      global $conn;

      $query = "UPDATE tetanus_info 
                          SET isPosted = 1
                          WHERE ttID = $ttID AND patientID = $patientID";
      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function setCalciumSchedule($calID, $patientID)
    {
      global $conn;

      $query = "UPDATE calcium_info 
                          SET isPosted = 1
                          WHERE calID = $calID AND patientID = $patientID";
      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function setIodineSchedule($iodineID, $patientID, $checkup_date)
    {
      global $conn;

      $iodineInfo = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM iodine_info WHERE iodID ='$iodineID'"));
      $iodineSched = mysqli_query($conn, "SELECT * FROM iodine_sched WHERE patientID ='$patientID' AND iodSchedDate='$checkup_date'");

      if (mysqli_num_rows($iodineSched) == 0) {
        mysqli_query(
          $conn,
          "INSERT INTO iodine_sched(patientID, iodSchedDate, iodSchedTablet, iodSchedStatus) VALUES('$patientID', '$checkup_date', '$iodineInfo->iodTablet', 'Pending')"
        );
      }

      $query = "UPDATE iodine_info 
                          SET isPosted = 1
                          WHERE iodID = '$iodineID' AND patientID = '$patientID'";
      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function setMicronutrientSchedule($ironID, $patientID)
    {
      global $conn;

      $query = "UPDATE micronutrient_info 
                          SET isPosted = 1
                          WHERE ironID = $ironID AND patientID = $patientID";
      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function updatePatientSched($scheduleID, $scheduleDate, $scheduleStatus, $scheduleType, $stationId)
    {
      global $conn;

      if ($scheduleStatus == "Completed") {
        $this->addInventoryHistory($scheduleID, $scheduleType, $stationId);
      }

      switch ($scheduleType) {
        case 'Tetanus':
          $query = "UPDATE tetanus_sched SET ttSchedDate = '$scheduleDate', ttSchedStatus = '$scheduleStatus' WHERE ttSchedID = '$scheduleID'";
          break;
        case 'Calcium':
          $query = "UPDATE calcium_sched SET calSchedDate = '$scheduleDate', calSchedStatus = '$scheduleStatus' WHERE calSchedID = '$scheduleID'";
          break;
        case 'Iodine':
          $query = "UPDATE iodine_sched SET iodSchedDate = '$scheduleDate', iodSchedStatus = '$scheduleStatus' WHERE iodSchedID  = '$scheduleID'";
          break;
        case 'Deworming':
          $query = "UPDATE deworming_sched SET dwSchedDate = '$scheduleDate', dwSchedStatus = '$scheduleStatus' WHERE dwSchedID = '$scheduleID'";
          break;
        case 'Micronutrient':
          $query = "UPDATE micronutrient_sched SET ironSchedDate = '$scheduleDate', ironSchedStatus = '$scheduleStatus' WHERE ironSchedID = '$scheduleID'";
          break;
        case 'Pre-natal':
          $query = "UPDATE `pre-natal_sched` SET pnSchedCheckupDate = '$scheduleDate', pnSchedStatus = '$scheduleStatus' WHERE pnSchedID = '$scheduleID'";
          break;
        default:
          return false;
      }

      $result = mysqli_query($conn, $query);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }

    public function addInventoryHistory($scheduleID, $scheduleType, $stationId)
    {
      global $conn;

      $category = "";

      switch ($scheduleType) {
        case 'Calcium':
          $query = "SELECT 
                      cal.patientID AS 'patient_id',
                      cal.calSchedTablets AS 'quantity'
                    FROM calcium_sched cal 
                    WHERE cal.calSchedID='$scheduleID'";
          $category = "calcium";
          break;
        case 'Iodine':
          $query = "SELECT 
                      iod.patientID AS 'patient_id',
                      iod.iodSchedTablet AS 'quantity'
                    FROM iodine_sched iod 
                    WHERE iod.iodSchedID ='$scheduleID'";
          $category = "iodine";
          break;
        case 'Deworming':
          $query = "SELECT 
                      dew.patientID AS 'patient_id',
                      dew.dwSchedTablet AS 'quantity'
                    FROM deworming_sched dew 
                    WHERE dew.dwSchedID='$scheduleID'";
          $category = "deworming";
          break;
        case 'Micronutrient':
          $query = "SELECT 
                      mic.patientID AS 'patient_id',
                      mic.ironSchedTablets AS 'quantity'
                    FROM micronutrient_sched mic 
                    WHERE mic.ironSchedID='$scheduleID'";
          $category = "iron";
          break;
      }

      $res = mysqli_query($conn, $query);
      $scheduleData = mysqli_num_rows($res) > 0 ? mysqli_fetch_object($res) : null;

      $medicineQ = mysqli_query(
        $conn,
        "SELECT
          m.medicineID,
          m.medicineName,
          m.medicineCategory
        FROM medicine m
        WHERE m.medicineCategory LIKE '%$category%' LIMIT 1"
      );

      $medicine = mysqli_num_rows($medicineQ) > 0 ? mysqli_fetch_object($medicineQ) : null;

      $addInventoryHistory = mysqli_query(
        $conn,
        "INSERT INTO inventory_history(patient_id, medicine_id, quantity) VALUES('$scheduleData->patient_id', '$medicine->medicineID', '$scheduleData->quantity')"
      );

      if ($addInventoryHistory) {
        $this->updateInventory($medicine->medicineID, $stationId, $scheduleData->quantity);
      }
    }

    public function updateInventory($medicineId, $stationId, $quantity)
    {
      global $conn;

      if ($medicineId) {
        $inventoryQ = mysqli_query(
          $conn,
          "SELECT *
          FROM inventory i
          WHERE i.stationID = '$stationId'
          AND i.medicineID = '$medicineId'"
        );

        $inventory_data = mysqli_num_rows($inventoryQ) > 0 ? mysqli_fetch_object($inventoryQ) : null;

        if ($inventory_data) {
          $newQuantity = intval($inventory_data->availableStock) - intval($quantity);

          $updateInventory = mysqli_query(
            $conn,
            "UPDATE inventory SET availableStock='$newQuantity' WHERE inventoryID='$inventory_data->inventoryID'"
          );
        }
      }
    }
  }
}
