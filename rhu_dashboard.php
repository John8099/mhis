<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
    header('Location: index.php');
    exit();
}

include('includes/header.php');
include('includes/rhu_navbar.php');

$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
}

// TOTAL REGISTERED PATIENTS
$totalPatientsQuery = "SELECT COUNT(*) as totalPatients FROM patient p LEFT JOIN barangay b ON p.barangayID = b.barangayID";
$totalPatientsResult = mysqli_query($conn, $totalPatientsQuery);
if ($patientsRow = mysqli_fetch_assoc($totalPatientsResult)){
    $totalPatients = $patientsRow['totalPatients'];
}

// TOTAL NUMBER OF BABY'S SEX DISTRIBUTION
$poBabySexQuery = "SELECT 
    SUM(CASE WHEN poBabySex = 'M' THEN 1 ELSE 0 END) as maleCount,
    SUM(CASE WHEN poBabySex = 'F' THEN 1 ELSE 0 END) as femaleCount
    FROM pregnancy_outcome po
    LEFT JOIN patient p ON po.patientID = p.patientID
    LEFT JOIN barangay b ON p.barangayID = b.barangayID
";
$poBabySexResult = mysqli_query($conn, $poBabySexQuery);

$maleCount = 0;
$femaleCount = 0;

if ($poBabySexResult && mysqli_num_rows($poBabySexResult) > 0) {
    $poBabySexData = mysqli_fetch_assoc($poBabySexResult);
    $maleCount = $poBabySexData['maleCount'];
    $femaleCount = $poBabySexData['femaleCount'];
}

// TOTAL NUMBER OF BABY'S WEIGHT DISTRIBUTION BY SEX
$poBabyWeightQuery = "SELECT 
    SUM(CASE WHEN poBabySex = 'M' AND poBabyWeight >= 2.5 THEN 1 ELSE 0 END) as male2500Plus,
    SUM(CASE WHEN poBabySex = 'M' AND poBabyWeight > 0 AND poBabyWeight < 2.5 THEN 1 ELSE 0 END) as maleLessThan2500,
    SUM(CASE WHEN poBabySex = 'M' AND (poBabyWeight = 0 OR poBabyWeight IS NULL) THEN 1 ELSE 0 END) as maleNotKnown,
    SUM(CASE WHEN poBabySex = 'F' AND poBabyWeight >= 2.5 THEN 1 ELSE 0 END) as female2500Plus,
    SUM(CASE WHEN poBabySex = 'F' AND poBabyWeight > 0 AND poBabyWeight < 2.5 THEN 1 ELSE 0 END) as femaleLessThan2500,
    SUM(CASE WHEN poBabySex = 'F' AND (poBabyWeight = 0 OR poBabyWeight IS NULL) THEN 1 ELSE 0 END) as femaleNotKnown
    FROM pregnancy_outcome po
    LEFT JOIN patient p ON po.patientID = p.patientID
    LEFT JOIN barangay b ON p.barangayID = b.barangayID
";
$poBabyWeightResult = mysqli_query($conn, $poBabyWeightQuery);

$male2500Plus = $maleLessThan2500 = $maleNotKnown = 0;
$female2500Plus = $femaleLessThan2500 = $femaleNotKnown = 0;

if ($poBabyWeightResult && mysqli_num_rows($poBabyWeightResult) > 0) {
    $poBabyWeightData = mysqli_fetch_assoc($poBabyWeightResult);
    $male2500Plus = $poBabyWeightData['male2500Plus'];
    $maleLessThan2500 = $poBabyWeightData['maleLessThan2500'];
    $maleNotKnown = $poBabyWeightData['maleNotKnown'];
    $female2500Plus = $poBabyWeightData['female2500Plus'];
    $femaleLessThan2500 = $poBabyWeightData['femaleLessThan2500'];
    $femaleNotKnown = $poBabyWeightData['femaleNotKnown'];
}

// TOTAL NUMBER OF BIRTH ATTENDANT TYPES
$poBirthAttendantQuery = "SELECT 
    SUM(CASE WHEN poBirthAttendant = 'MD' THEN 1 ELSE 0 END) as doctorCount,
    SUM(CASE WHEN poBirthAttendant = 'RN' THEN 1 ELSE 0 END) as nurseCount,
    SUM(CASE WHEN poBirthAttendant = 'MW' THEN 1 ELSE 0 END) as midwifeCount,
    SUM(CASE WHEN poBirthAttendant = 'H' THEN 1 ELSE 0 END) as hilotCount,
    SUM(CASE WHEN poBirthAttendant = 'O' THEN 1 ELSE 0 END) as otherCount
    FROM pregnancy_outcome po
    LEFT JOIN patient p ON po.patientID = p.patientID
    LEFT JOIN barangay b ON p.barangayID = b.barangayID
";
$poBirthAttendantResult = mysqli_query($conn, $poBirthAttendantQuery);

$doctorCount = $nurseCount = $midwifeCount = $hilotCount = $otherCount = 0;

if ($poBirthAttendantResult && mysqli_num_rows($poBirthAttendantResult) > 0) {
    $poBirthAttendantData = mysqli_fetch_assoc($poBirthAttendantResult);
    $doctorCount = $poBirthAttendantData['doctorCount'];
    $nurseCount = $poBirthAttendantData['nurseCount'];
    $midwifeCount = $poBirthAttendantData['midwifeCount'];
    $hilotCount = $poBirthAttendantData['hilotCount'];
    $otherCount = $poBirthAttendantData['otherCount'];
}

// TOTAL NUMBER OF PLACE OF DELIVERY DISTRIBUTION
$poPlaceTypeQuery = "SELECT 
    SUM(CASE WHEN poPlaceType = 'BHS' THEN 1 ELSE 0 END) as bhsCount,
    SUM(CASE WHEN poPlaceType = 'RHUMIHC' THEN 1 ELSE 0 END) as rhumiHCCount,
    SUM(CASE WHEN poPlaceType = 'Lying-in' THEN 1 ELSE 0 END) as lyingInCount,
    SUM(CASE WHEN poPlaceType = 'Hospital' THEN 1 ELSE 0 END) as hospitalCount,
    SUM(CASE WHEN poPlaceType = 'Birthing Homes' THEN 1 ELSE 0 END) as birthingHomesCount,
    SUM(CASE WHEN poPlaceType = 'DOH Licensed Ambulance' THEN 1 ELSE 0 END) as dohAmbulanceCount
    FROM pregnancy_outcome po
    LEFT JOIN patient p ON po.patientID = p.patientID
    LEFT JOIN barangay b ON p.barangayID = b.barangayID
";
$poPlaceTypeResult = mysqli_query($conn, $poPlaceTypeQuery);

$bhsCount = $rhumiHCCount = $lyingInCount = $hospitalCount = $birthingHomesCount = $dohAmbulanceCount = 0;

if ($poPlaceTypeResult && mysqli_num_rows($poPlaceTypeResult) > 0) {
    $poPlaceTypeData = mysqli_fetch_assoc($poPlaceTypeResult);
    $bhsCount = $poPlaceTypeData['bhsCount'];
    $rhumiHCCount = $poPlaceTypeData['rhumiHCCount'];
    $lyingInCount = $poPlaceTypeData['lyingInCount'];
    $hospitalCount = $poPlaceTypeData['hospitalCount'];
    $birthingHomesCount = $poPlaceTypeData['birthingHomesCount'];
    $dohAmbulanceCount = $poPlaceTypeData['dohAmbulanceCount'];
}

// TOTAL NUMBER OF OUTCOME DISTRIBUTION
$poOutcomeQuery = "SELECT 
    SUM(CASE WHEN poOutcome = 'FT' THEN 1 ELSE 0 END) as fullTermCount,
    SUM(CASE WHEN poOutcome = 'PT' THEN 1 ELSE 0 END) as preTermCount,
    SUM(CASE WHEN poOutcome = 'PD' THEN 1 ELSE 0 END) as fatalDeathCount
    FROM pregnancy_outcome po
    LEFT JOIN patient p ON po.patientID = p.patientID
    LEFT JOIN barangay b ON p.barangayID = b.barangayID
";
$poOutcomeResult = mysqli_query($conn, $poOutcomeQuery);

$fullTermCount = $preTermCount = $fatalDeathCount = 0;

if ($poOutcomeResult && mysqli_num_rows($poOutcomeResult) > 0) {
    $poOutcomeData = mysqli_fetch_assoc($poOutcomeResult);
    $fullTermCount = $poOutcomeData['fullTermCount'];
    $preTermCount = $poOutcomeData['preTermCount'];
    $fatalDeathCount = $poOutcomeData['fatalDeathCount'];
}

// Registered Patients by Month
$poPatientMonthQuery = "SELECT 
    MONTH(p.registrationDate) AS month, 
    COUNT(*) AS patientCount
    FROM patient p
    LEFT JOIN barangay b ON p.barangayID = b.barangayID

    GROUP BY MONTH(p.registrationDate)";
$poPatientMonthResult = mysqli_query($conn, $poPatientMonthQuery);

$months = [];
$patientCounts = [];

if ($poPatientMonthResult && mysqli_num_rows($poPatientMonthResult) > 0) {
    while ($row = mysqli_fetch_assoc($poPatientMonthResult)) {
        $months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); 
        $patientCounts[] = $row['patientCount'];
    }
}
?>

<div class="container text-center">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Registered Patients</div>
                    <h1 class="text-muted"><?php echo $totalPatients; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Registered Patients by Month</div>
                    <canvas id="poPatientMonthChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Outcomes Distribution</div>
                    <canvas id="poOutcomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Livebirth Sex Distribution</div>
                    <canvas id="poBabySexChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Weight of Livebirth by Sex</div>
                    <canvas id="poBabyWeightChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Birth Attendant Distribution</div>
                    <canvas id="poBirthAttendantChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-uppercase text-primary fw-bold text-m mb-3">Place of Delivery</div>
                    <canvas id="poPlaceTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // BABY SEX DISTRIBUTION COUNT
    const maleCount = <?php echo $maleCount; ?>;
    const femaleCount = <?php echo $femaleCount; ?>;
    new Chart(document.getElementById('poBabySexChart').getContext('2d'), {
        type: 'bar', 
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [maleCount, femaleCount],
                backgroundColor: ['#007bff', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw || 0;
                            const total = maleCount + femaleCount;
                            return `${value} (${((value / total) * 100).toFixed(2)}%)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 4 },
                    title: { display: true, text: 'Number of Livebirths' }
                },
                x: {
                    title: { display: true, text: 'Gender' }
                }
            }
        }
    });

    // WEIGHT DISTRIBUTION COUNT BY SEX
    const male2500Plus = <?php echo $male2500Plus; ?>;
    const maleLessThan2500 = <?php echo $maleLessThan2500; ?>;
    const maleNotKnown = <?php echo $maleNotKnown; ?>;
    const female2500Plus = <?php echo $female2500Plus; ?>;
    const femaleLessThan2500 = <?php echo $femaleLessThan2500; ?>;
    const femaleNotKnown = <?php echo $femaleNotKnown; ?>;

    new Chart(document.getElementById('poBabyWeightChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['2500 grams and greater', 'less than 2500 grams', 'not known'],
            datasets: [
                {
                    label: 'Male',
                    data: [male2500Plus, maleLessThan2500, maleNotKnown],
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    borderWidth: 1
                },
                {
                    label: 'Female',
                    data: [female2500Plus, femaleLessThan2500, femaleNotKnown],
                    backgroundColor: '#dc3545',
                    borderColor: '#dc3545',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw || 0;
                            const total = male2500Plus + maleLessThan2500 + maleNotKnown +
                                        female2500Plus + femaleLessThan2500 + femaleNotKnown;
                            return `${context.dataset.label}: ${value} (${((value / total) * 100).toFixed(2)}%)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 4 },
                    title: { display: true, text: 'Number of Livebirths' }
                },
                x: {
                    title: { display: true, text: 'Weight Category' }
                }
            }
        }
    });

    // BIRTH ATTENDANT DISTRIBUTION COUNT
    const doctorCount = <?php echo $doctorCount; ?>;
    const nurseCount = <?php echo $nurseCount; ?>;
    const midwifeCount = <?php echo $midwifeCount; ?>;
    const hilotCount = <?php echo $hilotCount; ?>;
    const otherCount = <?php echo $otherCount; ?>;

    new Chart(document.getElementById('poBirthAttendantChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Doctor (MD)', 'Nurse (RN)', 'Midwife (MW)', 'Hilot/TBA (H)', 'Others (O)'],
            datasets: [{
                data: [doctorCount, nurseCount, midwifeCount, hilotCount, otherCount],
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#6c757d'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw || 0;
                            const total = doctorCount + nurseCount + midwifeCount + hilotCount + otherCount;
                            return `${context.label}: ${value} (${((value / total) * 100).toFixed(2)}%)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 4 },
                    title: { display: true, text: 'Number of Livebirths' }
                },
                x: {
                    title: { display: true, text: 'Birth Attendant' }
                }
            }
        }
    });

    // PLACE OF DELIVERY DISTRIBUTION COUNT
    const bhsCount = <?php echo $bhsCount; ?>;
    const rhumiHCCount = <?php echo $rhumiHCCount; ?>;
    const lyingInCount = <?php echo $lyingInCount; ?>;
    const hospitalCount = <?php echo $hospitalCount; ?>;
    const birthingHomesCount = <?php echo $birthingHomesCount; ?>;
    const dohAmbulanceCount = <?php echo $dohAmbulanceCount; ?>;

    new Chart(document.getElementById('poPlaceTypeChart').getContext('2d'), {
        type: 'bar', 
        data: {
            labels: ['BHS', 'RHUMIHC', 'Lying-in', 'Hospital', 'Birthing Homes', 'DOH Licensed Ambulance'],
            datasets: [{
                label: 'Number of Deliveries', 
                data: [bhsCount, rhumiHCCount, lyingInCount, hospitalCount, birthingHomesCount, dohAmbulanceCount],
                backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d'],
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true, 
                    ticks: { stepSize: 4 },
                    title: {
                        display: true,
                        text: 'Number of Deliveries'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Place of Delivery'
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw || 0;
                            return `${context.label}: ${value}`;
                        }
                    }
                }
            }
        }
    });

    // OUTCOME DISTRIBUTION COUNT
    const fullTermCount = <?php echo $fullTermCount; ?>;
    const preTermCount = <?php echo $preTermCount; ?>;
    const fatalDeathCount = <?php echo $fatalDeathCount; ?>;

    new Chart(document.getElementById('poOutcomeChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Full Term', 'Pre-Term', 'Fatal Death'],
            datasets: [{
                label: 'Outcome Distribution',
                data: [fullTermCount, preTermCount, fatalDeathCount],
                backgroundColor: ['#007bff', '#dc3545', '#ffc107'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 4 },
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw || 0;
                            return `${context.label}: ${value}`;
                        }
                    }
                }
            }
        }
    });

    // PATIENT BY MONTH
    var poPatientMonthCtx = document.getElementById('poPatientMonthChart').getContext('2d');
    var poPatientMonthChart = new Chart(poPatientMonthCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>, 
            datasets: [{
                label: 'Registered Patients',
                data: <?php echo json_encode($patientCounts); ?>, 
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 4 },
                    title: {
                        display: true,
                        text: 'Number of Patients'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });
    
</script>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
