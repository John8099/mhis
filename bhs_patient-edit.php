<?php
    session_start();
    if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
        header('Location: index.php');
        exit();
    }

    include ('includes/header.php');
    include ('includes/midwife_navbar.php');

    if (isset($_GET['id'])) {
        $patientID = $_GET['id'];
        $query = "SELECT p.*, cal.*, dew.*, inf.*, lab.*, mic.*, prn.*, pro.*, tet.*, b.barangayName, b.stationID
                FROM patient p
                LEFT JOIN calcium_info cal ON p.patientID = cal.patientID 
                LEFT JOIN deworming_info dew ON p.patientID = dew.patientID
                LEFT JOIN infectious inf ON p.patientID = inf.patientID
                LEFT JOIN laboratory lab ON p.patientID = lab.patientID
                LEFT JOIN micronutrient_info mic ON p.patientID = mic.patientID
                LEFT JOIN `pre-natal_info` prn ON p.patientID = prn.patientID
                LEFT JOIN pregnancy_outcome pro ON p.patientID = pro.patientID
                LEFT JOIN tetanus_info tet ON p.patientID = tet.patientID
                LEFT JOIN barangay b ON p.barangayID = b.barangayID
                LEFT JOIN station s ON s.stationID = b.stationID 
                WHERE p.patientID = '$patientID';";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "<div class='alert alert-danger'>Invalid patient ID.</div>";
            exit;
        }
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

    .nav-buttons{
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
            <a href="bhs_patient-records.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i><span> Back</span></a>
            <h2 class="m-0 font-weight-bold text-primary text-center my-5">TARGET CLIENT LIST</h2>
            <form action="bhs-functions.php" method="POST">
                <!-- Page 1 -->
                <div class="card shadow mb-4 mx-auto" id="page1">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <a href="#collapsePage1" data-toggle="collapse" aria-expanded="true" aria-controls="collapsePage1">
                                <i class="fa-solid fa-plus" id="iconPage1"></i>
                                About Patient
                            </a>
                        </h5>
                    </div>
                    <div id="collapsePage1" class="collapse show">
                        <div class="card-body">
                            <input type="hidden" name="patientID" value="<?php echo $row['patientID'] ?>">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="serial_no">Family Serial No.</label>
                                    <input type="number" class="form-control" id="serial_no" name="patientSerialNumber" value="<?php echo $row['patientSerialNumber'] ?>" placeholder="Enter family serial no.">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Date of Registration</label>
                                    <input type="text" class="form-control" value="<?php echo $row['registrationDate'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                    <input type="text" name="patientFname" class="form-control" value="<?php echo $row['patientFname'] ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" name="patientMname" class="form-control" value="<?php echo $row['patientMname'] ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" name="patientLname" class="form-control" value="<?php echo $row['patientLname'] ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Birthday</label>
                                    <input type="date" name="patientBirthday" id="birthday" class="form-control" value="<?php echo $row['patientBirthday'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Age</label>
                                    <input type="number" name="patientAge" id="age" class="form-control" value="<?php echo $row['patientAge'] ?>" readonly required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Weight (kg)</label>
                                    <input type="number" name="patientWeight" id="weight" class="form-control" step="0.01" value="<?php echo $row['patientWeight'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Height (m)</label>
                                    <input type="number" name="patientHeight" id="height" class="form-control" step="0.01" value="<?php echo $row['patientHeight'] ?>" required> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>BMI Result</label>
                                    <input type="text" name="patientBMI" id="bmi" class="form-control" value="<?php echo $row['patientBMI'] ?>" readonly required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>BMI Category</label>
                                    <input type="text" name="patientBMICategory" id="bmiCategory" class="form-control" value="<?php echo $row['patientBMICategory'] ?>" readonly required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Blood Type</label>
                                    <select name="patientBloodType" class="form-control" required> 
                                        <option disabled <?php echo empty($row['patientBloodType']) ? 'selected' : ''; ?>>Select blood type</option>
                                        <option value="O+" <?php echo ($row['patientBloodType'] == 'O+') ? 'selected' : ''; ?>>O Positive</option>
                                        <option value="O-" <?php echo ($row['patientBloodType'] == 'O-') ? 'selected' : ''; ?>>O Negative</option>
                                        <option value="A+" <?php echo ($row['patientBloodType'] == 'A+') ? 'selected' : ''; ?>>A Positive</option>
                                        <option value="A-" <?php echo ($row['patientBloodType'] == 'A-') ? 'selected' : ''; ?>>A Negative</option>
                                        <option value="B+" <?php echo ($row['patientBloodType'] == 'B+') ? 'selected' : ''; ?>>B Positive</option>
                                        <option value="B-" <?php echo ($row['patientBloodType'] == 'B-') ? 'selected' : ''; ?>>B Negative</option>
                                        <option value="AB+" <?php echo ($row['patientBloodType'] == 'AB+') ? 'selected' : ''; ?>>AB Positive</option>
                                        <option value="AB-" <?php echo ($row['patientBloodType'] == 'AB-') ? 'selected' : ''; ?>>AB Negative</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="barangay">Barangay</label>
                                    <select name="patientBarangay" class="form-control" id="addStationBarangay" onchange="toggleBarangayButton()" required>
                                        <option value="0" disabled selected>Select Barangay</option>
                                        <?php
                                            $stationID = $row['stationID'];
                                            $barangayQuery = "SELECT * FROM barangay WHERE isActive = 1 and stationID = '$stationID' ORDER BY barangayName ASC";
                                            $barangayResult = mysqli_query($conn, $barangayQuery);
                                            $selectedBarangayID = $row['barangayID'];
                                            while($barangayRow = mysqli_fetch_assoc($barangayResult)) {
                                                $barangayID   = $barangayRow['barangayID'];
                                                $barangayName = $barangayRow['barangayName'];

                                                $selected = (isset($selectedBarangayID) && $barangayID == $selectedBarangayID) ? 'selected' : '';

                                                echo "<option value=\"$barangayID\" $selected>$barangayName</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Contact No.</label>
                                    <?php echo $row['patientContactNumber']; ?>
                                    <input type="text" name="patientContactNumber" placeholder="Patient's contact number" class="form-control" maxlength="11" value="<?php echo $row['patientContactNumber'] ?>" oninput="validateNumberInput(this)">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Emergency Contact</label>
                                    <input type="text" name="patientEmergencyContact" placeholder="Patient's emergencey contact number" maxlength="11" class="form-control" value="<?php echo $row['patientEmergencyContact'] ?>" oninput="validateNumberInput(this)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Socio Economic Status</label>
                                <select name="patientNHTS" class="form-control" required> 
                                    <option value="1" <?php if ($row['patientNHTS'] === '1') echo 'selected'; ?>>NHTS</option>
                                    <option value="2" <?php if ($row['patientNHTS'] === '0')echo 'selected'; ?>>Non-NHTS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Page 2 -->
                <div class="card shadow mb-4" id="page2">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-plus" id="iconPage2"></i>
                            <a href="#collapsePage2" data-toggle="collapse" aria-expanded="true" aria-controls="collapsePage2">Pre-Natal Check-ups</a>
                        </h5>
                    </div>
                    <div id="collapsePage2" class="collapse">
                        <div class="card-body">
                            <label><strong>Date of Last Menstrual Period</strong></label>
                            <div class="form-group row">
                                <div class="form-group col-md-4">
                                    <label>Last Menstrual Period</label>
                                    <input type="date" id="lmp" name="pnLMP" class="form-control" value="<?php echo $row['pnLMP'] ?>" onchange="calculateEDC()">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Gravidity</label>
                                    <input type="text" name="pnGravidity" class="form-control mb-2" value="<?php echo $row['pnGravidity'] ?>">
                                    <label>Parity</label>
                                    <input type="text" name="pnParity" class="form-control" value="<?php echo $row['pnParity'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Estimated Date of Confinement</label>
                                    <input type="date" id="edc" name="pnEDC" class="form-control" value="<?php echo $row['pnEDC'] ?>" readonly>
                                </div>
                            </div>
                            <label><strong>Date of Pre-natal Check-ups</strong></label>
                            <div class="form-group row">
                                <div class="form-group col-md-3"> 
                                    <label>1st Trimester</label>
                                    <input type="date" class="form-control" id="pnTrimester1" name="pnTrimester1" placeholder="1st Trimester visit" value="<?php echo $row['pnTrimester1'] ?>" onchange="updateTrimesterDates()">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>2nd Trimester</label>
                                    <input type="date" class="form-control" id="pnTrimester2" name="pnTrimester2" placeholder="2nd Trimester visit" value="<?php echo $row['pnTrimester2'] ?>" onchange="updateTrimester2()">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>3rd Trimester (1st Visit)</label>
                                    <input type="date" class="form-control" id="pnTrimester3" name="pnTrimester3" placeholder="3rd Trimester, 1st visit" value="<?php echo $row['pnTrimester3'] ?>" onchange="updateTrimester3FirstVisit()">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>3rd Trimester (2nd Visit)</label>
                                    <input type="date" class="form-control" id="pnTrimester4" name="pnTrimester4" placeholder="3rd Trimester, 2nd visit" value="<?php echo $row['pnTrimester4'] ?>" onchange="updateTrimester3SecondVisit()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page 3 -->
                <div class="card shadow mb-4" id="page3">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-plus" id="iconPage3"></i>
                            <a href="#collapsePage3" data-toggle="collapse" aria-expanded="true" aria-controls="collapsePage3">Immunization and Micronutrient Supplementation</a>
                        </h5>
                    </div>
                    <div id="collapsePage3" class="collapse">
                        <div class="card-body">
                            <label><strong>Immunization Status</strong></label>
                            <br>
                            <label>Date Tetanus diptheria (Td) or Tetanus Toxoid (TT) given</label>
                            <div class="form-group row">
                                <div class="form-group col-md-2">
                                    <label for="tt1">Td1/TT1</label>
                                    <input type="date" class="form-control" id="td1_tt1" name="tt1" value="<?php echo $row['tt1'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="tt2">Td2/TT2</label>
                                    <input type="date" class="form-control" id="td2_tt2" name="tt2" value="<?php echo $row['tt2'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="tt3">Td3/TT3</label>
                                    <input type="date" class="form-control" id="td3_tt3" name="tt3" value="<?php echo $row['tt3'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="tt4">Td4/TT4</label>
                                    <input type="date" class="form-control" id="td4_tt4" name="tt4" value="<?php echo $row['tt4'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="tt5">Td5/TT5</label>
                                    <input type="date" class="form-control" id="td5_tt5" name="tt5" value="<?php echo $row['tt5'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ttFIM">FIM Status</label><br>
                                    <input type="hidden" name="ttFIM" value="0">
                                    <input type="checkbox" id="fim_status" name="ttFIM" value="1" <?php if ($row['ttFIM'] === '1') echo 'checked'; ?>>
                                    <label for="fim_status">Check</label>
                                </div>
                            </div>
                            <label><strong>Micronutrient Supplementation</strong></label>
                            <br>
                            <label>Iron sulfate with Folic Acid Date and Number of Tablets given</label>
                            <div class="form-group row">
                                <div class="form-group col-md-3">
                                    <label>1st trimester</label>
                                    <select class="form-control mb-2" id="iron_1st_tri_num" name="ironNum1">
                                        <option value="0" disabled <?php echo ($row['ironNum1'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                        <option value="30" <?php echo ($row['ironNum1'] == 30) ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($row['ironNum1'] == 60) ? 'selected' : ''; ?>>60</option>
                                    </select>
                                    <input type="date" class="form-control" id="ironTrimester1" name="ironDate1" placeholder="Date" value="<?php echo $row['ironDate1'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>2nd trimester</label>
                                    <select class="form-control mb-2" id="iron_2nd_tri_num" name="ironNum2">
                                        <option value="0" disabled <?php echo ($row['ironNum2'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                        <option value="30" <?php echo ($row['ironNum2'] == 30) ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($row['ironNum2'] == 60) ? 'selected' : ''; ?>>60</option>
                                    </select>
                                    <input type="date" class="form-control" id="ironTrimester2" name="ironDate2" placeholder="Date" value="<?php echo $row['ironDate2'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>3rd trimester (1st Visit)</label>
                                    <select class="form-control mb-2" id="iron_3rd_tri_num" name="ironNum3">
                                        <option value="0" disabled <?php echo ($row['ironNum3'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                        <option value="30" <?php echo ($row['ironNum3'] == 30) ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($row['ironNum3'] == 60) ? 'selected' : ''; ?>>60</option>
                                    </select>
                                    <input type="date" class="form-control" id="ironTrimester3" name="ironDate3" placeholder="Date" value="<?php echo $row['ironDate3'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>3rd trimester (2nd Visit)</label>
                                    <select class="form-control mb-2" id="iron_4th_tri_num" name="ironNum4">
                                        <option value="0" disabled <?php echo ($row['ironNum4'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                        <option value="30" <?php echo ($row['ironNum4'] == 30) ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($row['ironNum4'] == 60) ? 'selected' : ''; ?>>60</option>
                                    </select>
                                    <input type="date" class="form-control" id="ironTrimester4" name="ironDate4" placeholder="Date" value="<?php echo $row['ironDate4'] ?>" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page 4 -->
                <div class="card shadow mb-4" id="page4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-plus" id="iconPage4"></i>
                            <a href="#collapsePage4" data-toggle="collapse" aria-expanded="true" aria-controls="collapsePage4">Calcium Carbonate and Deworming</a>
                        </h5>
                    </div>
                    <div id="collapsePage4" class="collapse">
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>Calcium Carbonate Date and Number of Tablets given</strong></label>
                                <div class="form-group row">
                                    <div class="form-group col-md-4">
                                        <label>2nd trimester</label>
                                        <select class="form-control mb-2" id="calcium_2nd_tri_num" name="calNum1">
                                            <option value="0" disabled <?php echo ($row['calNum1'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                            <option value="150" <?php echo ($row['calNum1'] == 150) ? 'selected' : ''; ?>>150</option>
                                        </select>
                                        <input type="date" class="form-control" id="calTrimester2" name="calDate1" placeholder="Date" value="<?php echo $row['calDate1'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>3rd trimester (1st Visit)</label>
                                        <select class="form-control mb-2" id="calcium_3rd_tri_num" name="calNum2">
                                            <option value="0" disabled <?php echo ($row['calNum2'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                            <option value="150" <?php echo ($row['calNum2'] == 150) ? 'selected' : ''; ?>>150</option>
                                        </select>
                                        <input type="date" class="form-control" id="calTrimester3" name="calDate2" placeholder="Date" value="<?php echo $row['calDate2'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>3rd trimester (2nd Visit)</label>
                                        <select class="form-control mb-2" id="calcium_4th_tri_num" name="calNum3">
                                            <option value="0" disabled <?php echo ($row['calNum3'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                            <option value="150" <?php echo ($row['calNum3'] == 150) ? 'selected' : ''; ?>>150</option>
                                        </select>
                                        <input type="date" class="form-control" id="calTrimester4" name="calDate3" placeholder="Date" value="<?php echo $row['calDate3'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-4">
                                        <label><strong>Iodine Capsule (Date 2 capsules given)</strong></label>
                                        <label>1st trimester</label>
                                        <select class="form-control mb-2" id="iodine_1st_tri_num" name="iodNum">
                                            <option value="0" disabled <?php echo ($row['iodNum'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                            <option value="1" <?php echo ($row['iodNum'] == 1) ? 'selected' : ''; ?>>1</option>
                                        </select>
                                        <input type="date" class="form-control" id="iodTrimester1" name="iodDate" placeholder="Date" value="<?php echo $row['iodDate'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><strong>Nutritional Assessment (BMI for 1st Tri)</strong></label>
                                        <div class="form-group">
                                            <label>Nutritional Assessment</label>
                                            <div class="radio-label">
                                                <input type="radio" name="nutritionalAssessment" id="nutritional_assessment_low" value="1" <?php if ($row['nutritionalAssessment'] === "1") echo 'checked'; ?>>
                                                <label for="nutritional_assessment_low">Low (< 18.5)</label>
                                            </div>
                                            <div class="radio-label">
                                                <input type="radio" name="nutritionalAssessment" id="nutritional_assessment_normal" value="2" <?php if ($row['nutritionalAssessment'] === "2") echo 'checked'; ?>>
                                                <label for="nutritional_assessment_normal">Normal (18.5 - 22.9)</label>
                                            </div>
                                            <div class="radio-label">
                                                <input type="radio" name="nutritionalAssessment" id="nutritional_assessment_high" value="3" <?php if ($row['nutritionalAssessment'] === "3") echo 'checked'; ?>>
                                                <label for="nutritional_assessment_high">High (> 23.0)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><strong>Deworming</strong></label>
                                        <select class="form-control mb-2" id="deworming_tablet" name="dwTablet">
                                            <option value="0" disabled <?php echo ($row['dwTablet'] == 0) ? 'selected' : ''; ?>>Select number of tablets</option>
                                            <option value="1" <?php echo ($row['dwTablet'] == 1) ? 'selected' : ''; ?>>1</option>
                                        </select>
                                        <input type="date" class="form-control" id="deworming_date" name="dwDate" placeholder="" value="<?php echo $row['dwDate'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page 5 -->
                <div class="card shadow mb-4" id="page5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-plus" id="iconPage5"></i>
                            <a href="#collapsePage5" data-toggle="collapse" aria-expanded="true" aria-controls="collapsePage5">Screening</a>
                        </h5>
                    </div>
                    <div id="collapsePage5" class="collapse">
                        <div class="card-body">
                            <label><strong>Infectious Disease Surveillance</strong></label>
                            <div class="form-group row">
                                <div class="form-group col-md-4">
                                    <label>Syphilis Screening (RPR or RDT Result)</label>
                                    <input type="date" class="form-control mb-2" id="syphilis_date" name="syphilisDate" placeholder="Date" value="<?php echo $row['syphilisDate'] ?>">
                                    <select class="form-control" id="syphilis_result" name="syphilisResult">
                                        <option value="" <?php if (empty($row['syphilisResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                        <option value="1" <?php if ($row['syphilisResult'] === '1') echo 'selected'; ?>>Positive</option>
                                        <option value="0" <?php if ($row['syphilisResult'] === '0') echo 'selected'; ?>>Negative</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Hepatitis B Screening</label>
                                    <input type="date" class="form-control mb-2" id="hepatitis_b_date" name="hepatitisDate" placeholder="Date" value="<?php echo $row['hepatitisDate'] ?>">
                                    <select class="form-control" id="hepatitis_b_result" name="hepatitisResult">
                                        <option value="" <?php if (empty($row['hepatitisResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                        <option value="1" <?php if ($row['hepatitisResult'] === '1') echo 'selected'; ?>>Positive</option>
                                        <option value="0" <?php if ($row['hepatitisResult'] === '0') echo 'selected'; ?>>Negative</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>HIV Screening Date Screened</label>
                                    <input type="date" class="form-control mb-2" id="hiv_screening_date" name="hivScreeningDate" placeholder="Date" value="<?php echo $row['hivScreeningDate'] ?>">
                                </div>
                            </div>
                            <label><strong>Laboratory Screening</strong></label>
                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label>Gestational Diabetes</label>
                                    <input type="date" class="form-control mb-2" id="gestational_diabetes_date" name="gestationalDate" placeholder="Date Screened" value="<?php echo $row['gestationalDate'] ?>">
                                    <select class="form-control" id="gestational_diabetes_result" name="gestationalResult">
                                        <option value="" <?php if (empty($row['gestationalResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                        <option value="1" <?php if ($row['gestationalResult'] === '1') echo 'selected'; ?>>Positive</option>
                                        <option value="0" <?php if ($row['gestationalResult'] === '0') echo 'selected'; ?>>Negative</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>CBC/Hgb&Hct Count</label>
                                    <input type="date" class="form-control mb-2" id="cbc_hgb_hct_date" name="cbcHgbHctDate" placeholder="Date Screened" value="<?php echo $row['cbcHgbHctDate'] ?>">
                                    <select class="form-control mb-2" id="cbc_hgb_hct_result" name="cbcHgbHctResult">
                                    <option value="" <?php if (empty($row['cbcHgbHctResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                        <option value="1" <?php if ($row['cbcHgbHctResult'] === '1') echo 'selected'; ?>>With Anemia</option>
                                        <option value="0" <?php if ($row['cbcHgbHctResult'] === '0') echo 'selected'; ?>>Without Anemia</option>
                                    </select>
                                    <input type="text" class="form-control" id="cbc_hgb_hct_given_iron" name="cbcHgbHctIron" placeholder="Given iron"  value="<?php echo $row['cbcHgbHctIron'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page 6 -->
                <div class="card shadow mb-4" id="page6">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-plus" id="iconPage6"></i>
                            <a href="#collapsePage6" data-toggle="collapse" aria-expanded="true" aria-controls="collapsePage6">Pregnancy Outcome</a>
                        </h5>
                    </div>
                    <div id="collapsePage6" class="collapse">
                        <div class="card-body">
                            <label><strong>Date and Time of Delivery</strong></label>
                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label>Date</label>
                                    <input type="date" class="form-control" id="delivery_date" name="poDeliveryDate" value="<?php echo $row['poDeliveryDate'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Time</label>
                                    <input type="time" class="form-control" id="delivery_time" name="poDeliveryTime" value="<?php echo $row['poDeliveryTime'] ?>">
                                </div>
                            </div>
                            <label><strong>Pregnancy Outcome</strong></label>
                            <br>
                            <label>(Obtain data from the health facility record and LCR and reconcile tp avoid double reporting)</label>
                            <div class="form-group row">
                                <div class="form-group col-md-2">
                                    <label>Date Terminated</label>
                                    <input type="date" class="form-control" id="pregnancy_terminated_date" name="poTerminatedDate" placeholder="Date Screened" value="<?php echo $row['poTerminatedDate'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Outcome</label>
                                    <select class="form-control" id="pregnancy_outcome" name="poOutcome">
                                    <option value="" <?php if (empty($row['poOutcome'])) echo 'selected'; ?> disabled>Select Outcome</option>
                                        <option value="FT" <?php if ($row['poOutcome'] === 'FT') echo 'selected'; ?>>Full Term</option>
                                        <option value="PT" <?php if ($row['poOutcome'] === 'PT') echo 'selected'; ?>>Pre-Term</option>
                                        <option value="FD" <?php if ($row['poOutcome'] === 'FD') echo 'selected'; ?>>Fatal Death</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Sex</label>
                                    <select class="form-control" id="sex" name="poBabySex">
                                        <option value="" <?php if (empty($row['poBabySex'])) echo 'selected'; ?> disabled>Select Sex</option>
                                        <option value="F" <?php if ($row['poBabySex'] === 'F') echo 'selected'; ?>>Female</option>
                                        <option value="M" <?php if ($row['poBabySex'] === 'M') echo 'selected'; ?>>Male</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Weight</label>
                                    <input type="number" class="form-control mb-2" id="baby_weight" name="poBabyWeight" step=".01" placeholder="Weight in kilograms (kg)" value="<?php echo $row['poBabyWeight'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Type of Delivery</label>
                                    <select class="form-control" id="type_of_delivery_date" name="poDeliveryType">
                                        <option value="" <?php if (empty($row['poDeliveryType'])) echo 'selected'; ?> disabled>Select Delivery Type</option>
                                        <option value="Vaginal Delivery" <?php if ($row['poDeliveryType'] === 'Vaginal Delivery') echo 'selected'; ?>>Vaginal Delivery (VD)</option>
                                        <option value="Cesarian Section" <?php if ($row['poDeliveryType'] === 'Cesarian Section') echo 'selected'; ?>>Cesarian Section (CS)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label><strong>Place of Delivery</strong></label>
                                    <select class="form-control" id="place_of_delivery_type" name="poPlaceType" onchange="toggleOtherPlaceField()">
                                        <option value="" <?php if (empty($row['poPlaceType'])) echo 'selected'; ?>>Select Delivery Place Type</option>
                                        <option value="BHS" <?php if ($row['poPlaceType'] === 'BHS') echo 'selected'; ?>>Barangay Health Station</option>
                                        <option value="RHUMIHC" <?php if ($row['poPlaceType'] === 'RHUMIHC') echo 'selected'; ?>>RHU/Municipal Health Center</option>
                                        <option value="Lying-in" <?php if ($row['poPlaceType'] === 'Lying-in') echo 'selected'; ?>>Lying-in Clinic</option>
                                        <option value="Hospital" <?php if ($row['poPlaceType'] === 'Hospital') echo 'selected'; ?>>Hospital</option>
                                        <option value="Birthing Homes" <?php if ($row['poPlaceType'] === 'Birthing Homes') echo 'selected'; ?>>Birthing Homes</option>
                                        <option value="DOH Licensed Ambulance" <?php if ($row['poPlaceType'] === 'DOH Licensed Ambulance') echo 'selected'; ?>>DOH Licensed Ambulance</option>
                                        <option value="Home" <?php if ($row['poPlaceType'] === 'Home') echo 'selected'; ?>>Home Birth</option>
                                        <option value="Others" <?php if (!in_array($row['poPlaceType'], ['BHS', 'RHUMIHC', 'Lying-in', 'Hospital', 'Birthing Homes', 'DOH Licensed Ambulance', 'Home'])) echo 'selected'; ?>>Others</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="birth_attendant"><strong>Birth Attendant</strong></label>
                                    <select class="form-control" id="birth_attendant" name="poBirthAttendant" onchange="toggleOtherBirthAttendantField()">
                                        <option value="" <?php if (empty($row['poBirthAttendant'])) echo 'selected'; ?> disabled>Select Birth Attendant</option>
                                        <option value="MD" <?php if ($row['poBirthAttendant'] === 'MD') echo 'selected'; ?>>Doctor</option>
                                        <option value="RN" <?php if ($row['poBirthAttendant'] === 'RN') echo 'selected'; ?>>Nurse</option>
                                        <option value="MW" <?php if ($row['poBirthAttendant'] === 'MW') echo 'selected'; ?>>Midwife</option>
                                        <option value="O" <?php if (!in_array($row['poBirthAttendant'], ['MD', 'RN', 'MW'])) echo 'selected'; ?>>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-6" id="other_place_field" style="display: <?php echo (!in_array($row['poPlaceType'], ['BHS', 'RHUMIHC', 'Lying-in', 'Hospital', 'Birthing Homes', 'DOH Licensed Ambulance', 'Home'])) ? 'block' : 'none'; ?>;">
                                    <label><strong>Please specify other place of delivery</strong></label>
                                    <input type="text" class="form-control" id="other_poPlaceType" name="other_poPlaceType" value="<?php echo isset($row['poPlaceType']) && !in_array($row['poPlaceType'], ['BHS', 'RHUMIHC', 'Lying-in', 'Hospital', 'Birthing Homes', 'DOH Licensed Ambulance', 'Home']) ? $row['poPlaceType'] : ''; ?>">
                                </div>
                                <div class="form-group col-md-6" id="other_birth_attendant_field" style="display: <?php echo (!in_array($row['poBirthAttendant'], ['MD', 'RN', 'MW'])) ? 'block' : 'none'; ?>;">
                                    <label for="other_birth_attendant"><strong>Please specify other birth attendant</strong></label>
                                    <input type="text" class="form-control" id="other_birth_attendant" name="other_poBirthAttendant" value="<?php echo isset($row['poBirthAttendant']) && !in_array($row['poBirthAttendant'], ['MD', 'RN', 'MW']) ? $row['poBirthAttendant'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success nav-buttons" id="updatebtn" name="updatePatient">Save</button>
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

    // JavaScript for BMI calculation
    function calculateBMI() {
        var weight = parseFloat(document.getElementById('weight').value); // Get weight input value
        var height = parseFloat(document.getElementById('height').value); // Get height input value
        if (weight && height) {
            var bmi = weight / (height * height); // Calculate BMI
            document.getElementById('bmi').value = bmi.toFixed(2); // Update BMI input field

            // Determine BMI category
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
            document.getElementById('bmiCategory').value = bmiCategory; // Update BMI category input field
        } else {
            document.getElementById('bmi').value = ''; // Clear BMI input field if weight or height is empty
            document.getElementById('bmiCategory').value = ''; // Clear BMI category input field if weight or height is empty
        }
    }
    // Add event listeners to weight and height input fields to trigger BMI calculation
    document.getElementById('weight').addEventListener('input', calculateBMI);
    document.getElementById('height').addEventListener('input', calculateBMI);

    function validateNumberInput(input) {
        input.value = input.value.replace(/\D/g, ''); // Remove any non-digit character
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11); // Trim the value to 11 digits
        }
    }
    
    function updateHIVRisk() {
        // Get the checkbox values
        var history_of_hiv = document.getElementById('history_of_hiv').checked;
        var partner_hiv_positive = document.getElementById('partner_hiv_positive').checked;
        var high_risk_behaviors = document.getElementById('high_risk_behaviors').checked;
        var history_of_stis = document.getElementById('history_of_stis').checked;
        var access_to_preventive_measures = document.getElementById('access_to_preventive_measures').checked;

        // Determine if any of the high-risk factors are present
        var high_risk = history_of_hiv || partner_hiv_positive || high_risk_behaviors || history_of_stis || access_to_preventive_measures;

        // Update the result message
        var resultElement = document.getElementById('hiv_risk_result');
        if (high_risk) {
            resultElement.value = "High Risk";
        } else {
            resultElement.value = "Low Risk";
        }
    }
    // Initialize HIV risk assessment result
    updateHIVRisk();

    function updateButtonVisibility() {
        if (currentPage === 1) {
            document.querySelector('button[onclick="prevPage()"]').style.display = 'none';
        } else {
            document.querySelector('button[onclick="prevPage()"]').style.display = 'inline-block';
        }

        if (currentPage === totalPages) {
            document.querySelector('button[onclick="nextPage()"]').style.display = 'none';
            document.getElementById('updatebtn').style.display = 'inline-block';
        } else {
            document.querySelector('button[onclick="nextPage()"]').style.display = 'inline-block';
            document.getElementById('updatebtn').style.display = 'none';
        }
    }

    function calculateEDC() {
        const lmpField = document.getElementById('lmp');
        const edcField = document.getElementById('edc');
        const trimester1Field = document.getElementById('pnTrimester1');
        const lmpDate = new Date(lmpField.value);

        if (!isNaN(lmpDate.getTime())) {
            const edcDate = new Date(lmpDate);
            edcDate.setFullYear(edcDate.getFullYear() + 1);
            edcDate.setMonth(edcDate.getMonth() - 3);
            edcDate.setDate(edcDate.getDate() + 7);

            edcField.value = edcDate.toISOString().split('T')[0];

            const trimester1Date = new Date(lmpDate);
            trimester1Date.setDate(trimester1Date.getDate() + (12 * 7)); 

            trimester1Field.value = trimester1Date.toISOString().split('T')[0];

            updateTrimesterDates();
        }
    }

    function updateTrimesterDates() {
        const trimester1Input = document.getElementById('pnTrimester1');
        const trimester1Date = new Date(trimester1Input.value);

        if (!isNaN(trimester1Date.getTime())) {
            const trimester2Date = new Date(trimester1Date);
            trimester2Date.setDate(trimester2Date.getDate() + (17 * 7)); // 17 weeks

            const trimester3Date = new Date(trimester1Date);
            trimester3Date.setDate(trimester3Date.getDate() + (25 * 7)); // 25 weeks

            const trimester4Date = new Date(trimester1Date);
            trimester4Date.setDate(trimester4Date.getDate() + (31 * 7)); // 31 weeks

            // Get references to all trimester input elements
            const pnTrimester2 = document.getElementById('pnTrimester2');
            const pnTrimester3 = document.getElementById('pnTrimester3');
            const pnTrimester4 = document.getElementById('pnTrimester4');

            const iodTrimester1 = document.getElementById('iodTrimester1');
            const calTrimester2 = document.getElementById('calTrimester2');
            const calTrimester3 = document.getElementById('calTrimester3');
            const calTrimester4 = document.getElementById('calTrimester4');
            const ironTrimester1 = document.getElementById('ironTrimester1');
            const ironTrimester2 = document.getElementById('ironTrimester2');
            const ironTrimester3 = document.getElementById('ironTrimester3');
            const ironTrimester4 = document.getElementById('ironTrimester4');

            // Set the values for each trimester based on trimester 1
            iodTrimester1.value = trimester1Date.toISOString().split('T')[0];
            ironTrimester1.value = trimester1Date.toISOString().split('T')[0];

            pnTrimester2.value = trimester2Date.toISOString().split('T')[0];
            calTrimester2.value = trimester2Date.toISOString().split('T')[0];
            ironTrimester2.value = trimester2Date.toISOString().split('T')[0];

            pnTrimester3.value = trimester3Date.toISOString().split('T')[0];
            calTrimester3.value = trimester3Date.toISOString().split('T')[0];
            ironTrimester3.value = trimester3Date.toISOString().split('T')[0];

            pnTrimester4.value = trimester4Date.toISOString().split('T')[0];
            calTrimester4.value = trimester4Date.toISOString().split('T')[0];
            ironTrimester4.value = trimester4Date.toISOString().split('T')[0];
        }
    }

    function updateTrimester2() {
        const trimester2Input = document.getElementById('pnTrimester2');
        const trimester2Date = new Date(trimester2Input.value);

        if (!isNaN(trimester2Date.getTime())) {
            document.getElementById('calTrimester2').value = trimester2Date.toISOString().split('T')[0];
            document.getElementById('ironTrimester2').value = trimester2Date.toISOString().split('T')[0];
        }
    }

    function updateTrimester3FirstVisit() {
        const trimester3FirstVisitInput = document.getElementById('pnTrimester3');
        const trimester3Date = new Date(trimester3FirstVisitInput.value);

        if (!isNaN(trimester3Date.getTime())) {
            document.getElementById('calTrimester3').value = trimester3Date.toISOString().split('T')[0];
            document.getElementById('ironTrimester3').value = trimester3Date.toISOString().split('T')[0];
        }
    }

    function updateTrimester3SecondVisit() {
        const trimester3SecondVisitInput = document.getElementById('pnTrimester4');
        const trimester3SecondDate = new Date(trimester3SecondVisitInput.value);

        if (!isNaN(trimester3SecondDate.getTime())) {
            document.getElementById('calTrimester4').value = trimester3SecondDate.toISOString().split('T')[0];
            document.getElementById('ironTrimester4').value = trimester3SecondDate.toISOString().split('T')[0];
        }
    }

    function toggleOtherPlaceField() {
        const placeTypeSelect = document.getElementById('place_of_delivery_type');
        const otherPlaceField = document.getElementById('other_place_field');
        otherPlaceField.style.display = placeTypeSelect.value === 'Others' ? 'block' : 'none';
    }

    function toggleOtherBirthAttendantField() {
        const birthAttendantSelect = document.getElementById('birth_attendant');
        const otherBirthAttendantField = document.getElementById('other_birth_attendant_field');
        otherBirthAttendantField.style.display = birthAttendantSelect.value === 'O' ? 'block' : 'none';
    }
</script>

<?php
include ('includes/scripts.php');
include ('includes/footer.php');
?>