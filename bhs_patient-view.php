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
        $query = "SELECT p.*, cal.*, dew.*, inf.*, lab.*, mic.*, prn.*, pro.*, tet.*, b.barangayName
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
                WHERE p.patientID = '$patientID'";
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
            <div class="justify-content-between m-0 d-flex">
                <a href="bhs_patient-records" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i><span> Back</span></a>
                <a href="print?id=<?php echo $patientID; ?>" target="_blank" class="btn btn-primary">Print</a>
            </div>
            <h2 class="m-0 font-weight-bold text-primary text-center my-5">TARGET CLIENT LIST</h2>
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
                        <input type="hidden" name="midedit_id" value="<?php echo $row['patientID'] ?>" readonly>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="serial_no">Family Serial No.</label>
                                <input type="text" class="form-control" value="<?php echo $row['patientSerialNumber'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Date of Registration</label>
                                <input type="text" class="form-control" value="<?php echo $row['registrationDate'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>First Name</label>
                                <input type="text" name="edit_first_name" class="form-control" value="<?php echo $row['patientFname'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Middle Name</label>
                                <input type="text" name="edit_middle_name" class="form-control" value="<?php echo $row['patientMname'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Last Name</label>
                                <input type="text" name="edit_last_name" class="form-control" value="<?php echo $row['patientLname'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Birthday</label>
                                <input type="date" name="edit_birthday" id="birthday" class="form-control" value="<?php echo $row['patientBirthday'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Age</label>
                                <input type="number" name="edit_age" id="age" class="form-control" value="<?php echo $row['patientAge'] ?>" readonly readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Weight (kg)</label>
                                <input type="number" name="edit_weight" id="weight" class="form-control" step="0.01" value="<?php echo $row['patientWeight'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Height (m)</label>
                                <input type="number" name="edit_height" id="height" class="form-control" step="0.01" value="<?php echo $row['patientHeight'] ?>" readonly> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>BMI Result</label>
                                <input type="text" name="edit_bmi" id="bmi" class="form-control" value="<?php echo $row['patientBMI'] ?>" readonly readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>BMI Category</label>
                                <input type="text" name="edit_bmiCategory" id="bmiCategory" class="form-control" value="<?php echo $row['patientBMICategory'] ?>" readonly readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Blood Type</label>
                                <select disabled name="patientBloodType" class="form-control"> 
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
                                <input type="text" class="form-control" id="patientStation" value="<?php echo $row['barangayName']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Contact No.</label>
                                <input type="text" name="edit_contact" class="form-control" maxlength="11" placeholder="Patient's contact number" value="<?php echo $row['patientContactNumber'] ?>" readonly oninput="validateNumberInput(this)">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Emergency Contact</label>
                                <input type="text" name="edit_emergency_contact" maxlength="11" class="form-control" placeholder="Patient's emergency contact number" value="<?php echo $row['patientEmergencyContact'] ?>" readonly oninput="validateNumberInput(this)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Socio Economic Status</label>
                            <select disabled name="edit_socio" class="form-control"> 
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
                                <input type="date" id="lmp" name="edit_lmp" class="form-control" value="<?php echo $row['pnLMP'] ?>" onchange="calculateEDC()" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Gravidity</label>
                                <input type="text" name="edit_lmp_g" class="form-control mb-2" value="<?php echo $row['pnGravidity'] ?>" readonly>
                                <label>Parity</label>
                                <input type="text" name="edit_lmp_p" class="form-control" value="<?php echo $row['pnParity'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Estimated Date of Confinement</label>
                                <input type="date" id="edc" name="edit_edc" class="form-control" value="<?php echo $row['pnEDC'] ?>" readonly>
                            </div>
                        </div>
                        <label><strong>Date of Pre-natal Check-ups</strong></label>
                        <div class="form-group row">
                            <div class="form-group col-md-3"> 
                                <label>1st Trimester</label>
                                <input type="date" class="form-control" name="edit_prenatal_checkup_1st_tri" placeholder="1st Trimester visit"value="<?php echo $row['pnTrimester1'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>2nd Trimester</label>
                                <input type="date" class="form-control" name="edit_prenatal_checkup_2nd_tri" placeholder="2nd Trimester visit" value="<?php echo $row['pnTrimester2'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>3rd Trimester</label>
                                <input type="date" class="form-control" name="edit_prenatal_checkup_3rd_tri" placeholder="3rd Trimester, 1st visit" value="<?php echo $row['pnTrimester3'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>3rd Trimester (2nd)</label>
                                <input type="date" class="form-control" name="edit_prenatal_checkup_4th_tri" placeholder="3rd Trimester, 2nd visit" value="<?php echo $row['pnTrimester4'] ?>" readonly>
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
                                <label for="td1_tt1">Td1/TT1</label>
                                <input type="date" class="form-control" id="td1_tt1" name="edit_td1_tt1" value="<?php echo $row['tt1'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="td2_tt2">Td2/TT2</label>
                                <input type="date" class="form-control" id="td2_tt2" name="edit_td2_tt2" value="<?php echo $row['tt2'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="td3_tt3">Td3/TT3</label>
                                <input type="date" class="form-control" id="td3_tt3" name="edit_td3_tt3" value="<?php echo $row['tt3'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="td4_tt4">Td4/TT4</label>
                                <input type="date" class="form-control" id="td4_tt4" name="edit_td4_tt4" value="<?php echo $row['tt4'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="td5_tt5">Td5/TT5</label>
                                <input type="date" class="form-control" id="td5_tt5" name="edit_td5_tt5" value="<?php echo $row['tt5'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="fim_status">FIM Status</label><br>
                                <input type="hidden" name="edit_fim_status" value="0">
                                <input type="checkbox" id="fim_status" name="edit_fim_status" value="1" <?php if ($row['ttFIM'] === '1') echo 'checked'; ?> disabled>
                                <label for="fim_status">Check</label>
                            </div>
                        </div>
                        <label><strong>Micronutrient Supplementation</strong></label>
                        <br>
                        <label>Iron sulfate with Folic Acid Date and Number of Tablets given</label>
                        <div class="form-group row">
                            <div class="form-group col-md-3">
                                <label>1st visit (1st trimester)</label>
                                <input type="number" class="form-control mb-2" id="iron_1st_tri_num" name="edit_iron_1st_tri_num" placeholder="Number of tablets" value="<?php echo $row['ironNum1'] ?>" readonly>
                                <input type="date" class="form-control" id="iron_1st_tri_date" name="edit_iron_1st_tri_date" placeholder="Date" value="<?php echo $row['ironDate1'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>2nd visit (2nd trimester)</label>
                                <input type="number" class="form-control mb-2" id="iron_2nd_tri_num" name="edit_iron_2nd_tri_num" placeholder="Number of tablets" value="<?php echo $row['ironNum2'] ?>" readonly>
                                <input type="date" class="form-control" id="iron_2nd_tri_date" name="edit_iron_2nd_tri_date" placeholder="Date" value="<?php echo $row['ironDate2'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>3rd visit (3rd trimester)</label>
                                <input type="number" class="form-control mb-2" id="iron_3rd_tri_num" name="edit_iron_3rd_tri_num" placeholder="Number of tablets" value="<?php echo $row['ironNum3'] ?>" readonly>
                                <input type="date" class="form-control" id="iron_3rd_tri_date" name="edit_iron_3rd_tri_date" placeholder="Date" value="<?php echo $row['ironDate3'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>4th visit (4th trimester)</label>
                                <input type="number" class="form-control mb-2" id="iron_4th_tri_num" name="edit_iron_4th_tri_num" placeholder="Number of tablets" value="<?php echo $row['ironNum4'] ?>" readonly>
                                <input type="date" class="form-control" id="iron_4th_tri_date" name="edit_iron_4th_tri_date" placeholder="Date" value="<?php echo $row['ironDate4'] ?>" readonly>
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
                                    <label>2nd visit (2nd trimester)</label>
                                    <input type="number" class="form-control mb-2" id="calcium_2nd_tri_num" name="edit_calcium_2nd_tri_num" placeholder="Number of tablets" value="<?php echo $row['calNum1'] ?>" readonly>
                                    <input type="date" class="form-control" id="calcium_2nd_tri_date" name="edit_calcium_2nd_tri_date" placeholder="Date" value="<?php echo $row['calDate1'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>3rd visit (3rd trimester)</label>
                                    <input type="number" class="form-control mb-2" id="calcium_3rd_tri_num" name="edit_calcium_3rd_tri_num" placeholder="Number of tablets" value="<?php echo $row['calNum2'] ?>" readonly>
                                    <input type="date" class="form-control" id="calcium_3rd_tri_date" name="edit_calcium_3rd_tri_date" placeholder="Date" value="<?php echo $row['calDate2'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>4th visit (4th trimester)</label>
                                    <input type="number" class="form-control mb-2" id="calcium_4th_tri_num" name="edit_calcium_4th_tri_num" placeholder="Number of tablets" value="<?php echo $row['calNum3'] ?>" readonly>
                                    <input type="date" class="form-control" id="calcium_4th_tri_date" name="edit_calcium_4th_tri_date" placeholder="Date" value="<?php echo $row['calDate3'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-md-4">
                                    <label><strong>Iodine Capsule (Date 2 capsules given)</strong></label>
                                    <label>1st visit (1st trimester)</label>
                                    <input type="number" class="form-control mb-2" id="iodine_1st_tri_num" name="edit_iodine_1st_tri_num" placeholder="Number of capsules" value="<?php echo $row['iodNum'] ?>" readonly>
                                    <input type="date" class="form-control" id="iodine_1st_tri_date" name="edit_iodine_1st_tri_date" placeholder="Date" value="<?php echo $row['iodDate'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label><strong>Nutritional Assessment (BMI for 1st Tri)</strong></label>
                                    <div class="form-group">
                                        <label>Nutritional Assessment</label>
                                        <div class="radio-label">
                                            <input type="radio" name="edit_nutritional_assessment" id="nutritional_assessment_low" value="1" <?php if ($row['nutritionalAssessment'] === "1") echo 'checked'; ?> disabled>
                                            <label for="nutritional_assessment_low">Low (< 18.5)</label>
                                        </div>
                                        <div class="radio-label">
                                            <input type="radio" name="edit_nutritional_assessment" id="nutritional_assessment_normal" value="2" <?php if ($row['nutritionalAssessment'] === "2") echo 'checked'; ?> disabled>
                                            <label for="nutritional_assessment_normal">Normal (18.5 - 22.9)</label>
                                        </div>
                                        <div class="radio-label">
                                            <input type="radio" name="edit_nutritional_assessment" id="nutritional_assessment_high" value="3" <?php if ($row['nutritionalAssessment'] === "3") echo 'checked'; ?> disabled>
                                            <label for="nutritional_assessment_high">High (> 23.0)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label><strong>Deworming</strong></label>
                                    <input type="number" class="form-control mb-2" id="calcium_4th_tri_num" name="edit_calcium_4th_tri_num" placeholder="Number of tablets" value="<?php echo $row['dwTablet'] ?>" readonly>
                                    <input type="date" class="form-control" id="deworming_date" name="edit_deworming_date" placeholder="" value="<?php echo $row['dwDate'] ?>" readonly>
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
                                <input type="date" class="form-control mb-2" id="syphilis_date" name="edit_syphilis_date" placeholder="Date" value="<?php echo $row['syphilisDate'] ?>" readonly>
                                <select disabled class="form-control" id="syphilis_result" name="edit_syphilis_result">
                                    <option value="" <?php if (empty($row['syphilisResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                    <option value="1" <?php if ($row['syphilisResult'] === '1') echo 'selected'; ?>>Positive</option>
                                    <option value="0" <?php if ($row['syphilisResult'] === '0') echo 'selected'; ?>>Negative</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Hepatitis B Screening</label>
                                <input type="date" class="form-control mb-2" id="hepatitis_b_date" name="edit_hepatitis_b_date" placeholder="Date" value="<?php echo $row['hepatitisDate'] ?>" readonly>
                                <select disabled class="form-control" id="hepatitis_b_result" name="edit_hepatitis_b_result">
                                    <option value="" <?php if (empty($row['hepatitisResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                    <option value="1" <?php if ($row['hepatitisResult'] === '1') echo 'selected'; ?>>Positive</option>
                                    <option value="0" <?php if ($row['hepatitisResult'] === '0') echo 'selected'; ?>>Negative</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>HIV Screening Date Screened</label>
                                <input type="date" class="form-control mb-2" id="hiv_screening_date" name="edit_hiv_screening_date" placeholder="Date" value="<?php echo $row['hivScreeningDate'] ?>" readonly>
                            </div>
                        </div>
                        <label><strong>Laboratory Screening</strong></label>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label>Gestational Diabetes</label>
                                <input type="date" class="form-control mb-2" id="gestational_diabetes_date" name="edit_gestational_diabetes_date" placeholder="Date Screened" value="<?php echo $row['gestationalDate'] ?>" readonly>
                                <select disabled class="form-control" id="gestational_diabetes_result" name="edit_gestational_diabetes_result">
                                    <option value="" <?php if (empty($row['gestationalResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                    <option value="1" <?php if ($row['gestationalResult'] === '1') echo 'selected'; ?>>Positive</option>
                                    <option value="0" <?php if ($row['gestationalResult'] === '0') echo 'selected'; ?>>Negative</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>CBC/Hgb&Hct Count</label>
                                <input type="date" class="form-control mb-2" id="cbc_hgb_hct_date" name="edit_cbc_hgb_hct_date" placeholder="Date Screened" value="<?php echo $row['cbcHgbHctDate'] ?>" readonly>
                                <select disabled class="form-control mb-2" id="cbc_hgb_hct_result" name="edit_cbc_hgb_hct_result">
                                <option value="" <?php if (empty($row['cbcHgbHctResult'])) echo 'selected'; ?> disabled>Select Result</option>
                                    <option value="1" <?php if ($row['cbcHgbHctResult'] === '1') echo 'selected'; ?>>With Anemia</option>
                                    <option value="0" <?php if ($row['cbcHgbHctResult'] === '0') echo 'selected'; ?>>Without Anemia</option>
                                </select>
                                <input type="text" class="form-control" id="cbc_hgb_hct_given_iron" name="edit_cbc_hgb_hct_given_iron" placeholder="Given iron"  value="<?php echo $row['cbcHgbHctIron'] ?>" readonly>
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
                                <input type="date" class="form-control" id="delivery_date" name="edit_delivery_date" value="<?php echo $row['poDeliveryDate'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Time</label>
                                <input type="time" class="form-control" id="delivery_time" name="edit_delivery_time" value="<?php echo $row['poDeliveryTime'] ?>" readonly>
                            </div>
                        </div>
                        <label><strong>Pregnancy Outcome</strong></label>
                        <br>
                        <label>(Obtain data from the health facility record and LCR and reconcile tp avoid double reporting)</label>
                        <div class="form-group row">
                            <div class="form-group col-md-2">
                                <label>Date Terminated</label>
                                <input type="date" class="form-control" id="pregnancy_terminated_date" name="edit_pregnancy_terminated_date" placeholder="Date Screened" value="<?php echo $row['poTerminatedDate'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Outcome</label>
                                <select disabled class="form-control" id="pregnancy_outcome" name="edit_pregnancy_outcome">
                                <option value="" <?php if (empty($row['poOutcome'])) echo 'selected'; ?> disabled>Select Outcome</option>
                                    <option value="FT" <?php if ($row['poOutcome'] === 'FT') echo 'selected'; ?>>Full Term</option>
                                    <option value="PT" <?php if ($row['poOutcome'] === 'PT') echo 'selected'; ?>>Pre-Term</option>
                                    <option value="FD" <?php if ($row['poOutcome'] === 'FD') echo 'selected'; ?>>Fatal Death</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Sex</label>
                                <select disabled class="form-control" id="sex" name="edit_sex">
                                    <option value="" <?php if (empty($row['poBabySex'])) echo 'selected'; ?> disabled>Select Sex</option>
                                    <option value="F" <?php if ($row['poBabySex'] === 'F') echo 'selected'; ?>>Female</option>
                                    <option value="M" <?php if ($row['poBabySex'] === 'M') echo 'selected'; ?>>Male</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Weight</label>
                                <input type="number" class="form-control mb-2" id="baby_weight" name="edit_baby_weight" placeholder="Number of tablets" value="<?php echo $row['poBabyWeight'] ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Type of Delivery</label>
                                <select disabled class="form-control" id="type_of_delivery_date" name="edit_type_of_delivery_date">
                                    <option value="" <?php if (empty($row['poDeliveryType'])) echo 'selected'; ?> disabled>Select Delivery Type</option>
                                    <option value="Vaginal Delivery" <?php if ($row['poDeliveryType'] === 'Vaginal Delivery') echo 'selected'; ?>>Vaginal Delivery (VD)</option>
                                    <option value="Cesarian Section" <?php if ($row['poDeliveryType'] === 'Cesarian Section') echo 'selected'; ?>>Cesarian Section (CS)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label><strong>Place of Delivery</strong></label>
                                <select class="form-control" id="place_of_delivery_type" name="poPlaceType" onchange="toggleOtherPlaceField()" disabled>
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
                                <select class="form-control" id="birth_attendant" name="poBirthAttendant" onchange="toggleOtherBirthAttendantField()" disabled>
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
                                <input readonly type="text" class="form-control" id="other_poPlaceType" name="other_poPlaceType" value="<?php echo isset($row['poPlaceType']) && !in_array($row['poPlaceType'], ['BHS', 'RHUMIHC', 'Lying-in', 'Hospital', 'Birthing Homes', 'DOH Licensed Ambulance', 'Home']) ? $row['poPlaceType'] : ''; ?>">
                            </div>
                            <div class="form-group col-md-6" id="other_birth_attendant_field" style="display: <?php echo (!in_array($row['poBirthAttendant'], ['MD', 'RN', 'MW'])) ? 'block' : 'none'; ?>;">
                                <label for="other_birth_attendant"><strong>Please specify other birth attendant</strong></label>
                                <input readonly type="text" class="form-control" id="other_birth_attendant" name="other_poBirthAttendant" value="<?php echo isset($row['poBirthAttendant']) && !in_array($row['poBirthAttendant'], ['MD', 'RN', 'MW']) ? $row['poBirthAttendant'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include ('includes/scripts.php');
include ('includes/footer.php');
?>