<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
    header('Location: index.php');
    exit();
}

include('includes/header.php');
include('includes/rhu_navbar.php');
$username = $_SESSION['user'];

$query = "SELECT * FROM user WHERE userUname = '$username' AND userType = 'RHU'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
}

$outcomeFilter = isset($_GET['outcomeFilter']) ? $_GET['outcomeFilter'] : '';
$stationFilter = isset($_GET['stationFilter']) ? $_GET['stationFilter'] : true;

$stations_query = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
$stations_result = mysqli_query($conn, $stations_query);

$query = "
    SELECT 
        b.barangayName, 
        po.poOutcome, 
        COUNT(po.poOutcome) as outcomeCount
    FROM 
        barangay b
    LEFT JOIN 
        patient p ON p.barangayID = b.barangayID AND p.isActive = 1
    LEFT JOIN 
        pregnancy_outcome po ON po.patientID = p.patientID
";

// Apply the station filter
if ($stationFilter) {
    $query .= " WHERE b.stationID = '$stationFilter'";
}

// Apply the outcome filter
if ($outcomeFilter) {
    $query .= " AND po.poOutcome = '$outcomeFilter'";
}

$query .= " GROUP BY b.barangayName, po.poOutcome
            ORDER BY b.barangayName, po.poOutcome";

// Execute the query
$result = mysqli_query($conn, $query);

// Initialize arrays for graph data
$barangays = [];
$outcomeFT = [];
$outcomePT = [];
$outcomeFD = [];

// Process the query results
while ($row = mysqli_fetch_assoc($result)) {
    $barangays[] = $row['barangayName'];
    switch ($row['poOutcome']) {
        case 'FT':
            $outcomeFT[] = $row['outcomeCount'];
            break;
        case 'PT':
            $outcomePT[] = $row['outcomeCount'];
            break;
        case 'FD':
            $outcomeFD[] = $row['outcomeCount'];
            break;
    }
}

// Convert the arrays to JSON for use in JavaScript
$barangays = json_encode($barangays);
$outcomeFT = json_encode($outcomeFT);
$outcomePT = json_encode($outcomePT);
$outcomeFD = json_encode($outcomeFD);
?>

<div class="container">
    <div class="row my-2">
        <div class="col-lg-12">
            <div class="card shadow my-2">
                <div class="card-header text-center">
                    <h5 class="m-0 font-weight-bold text-primary">Classification</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="" class="mb-3">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <label for="outcomeFilter">Select Outcome Filter</label>
                                <select name="outcomeFilter" id="outcomeFilter" class="form-control" onchange="this.form.submit()">
                                    <option value="" selected>All Outcomes</option>
                                    <option value="FT" <?php if ($outcomeFilter == 'FT') echo 'selected'; ?>>Full Term</option>
                                    <option value="PT" <?php if ($outcomeFilter == 'PT') echo 'selected'; ?>>Pre-term</option>
                                    <option value="FD" <?php if ($outcomeFilter == 'FD') echo 'selected'; ?>>Fatal Death</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="stationFilter">Select Station Filter</label>
                                <select name="stationFilter" id="stationFilter" class="form-control" onchange="this.form.submit()">
                                    <?php 
                                        $stations = [];
                                        while ($station = mysqli_fetch_assoc($stations_result)) {
                                            $stations[] = $station;
                                        }

                                        if (!$stationFilter && !empty($stations)) {
                                            $stationFilter = $stations[0]['stationID'];
                                        }

                                        foreach ($stations as $station) {
                                            $selected = ($stationFilter == $station['stationID']) ? 'selected' : ''; 
                                            echo '<option value="' . $station['stationID'] . '" ' . $selected . '>' . $station['stationName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <canvas id="outcomeChart"></canvas>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <table class="table table-bordered text-center mt-3">
                                <thead>
                                    <tr>
                                        <th>Pregnancy Outcome</th>
                                        <th><?php echo !$stationFilter ? 'Station Name' : 'Barangay Name'; ?></th>
                                        <th>Total Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $result = mysqli_query($conn, $query);
                                        $outcomes = []; 

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            $label = (!$stationFilter && isset($row['stationID'])) ? $row['stationID'] : $row['barangayName']; 

                                                $outcomes[$label][$row['poOutcome']] = $row['outcomeCount'];
                                            }
                                        }
                                        if ($stationFilter) {
                                            $barangay_query = "SELECT barangayName FROM barangay WHERE stationID = '$stationFilter' ORDER BY barangayName";
                                            $barangay_result = mysqli_query($conn, $barangay_query);

                                            while ($barangay = mysqli_fetch_assoc($barangay_result)) {
                                                $barangayName = $barangay['barangayName'];

                                                $outcomeFTCount = isset($outcomes[$barangayName]['FT']) ? $outcomes[$barangayName]['FT'] : 0;
                                                $outcomePTCount = isset($outcomes[$barangayName]['PT']) ? $outcomes[$barangayName]['PT'] : 0;
                                                $outcomeFDCount = isset($outcomes[$barangayName]['FD']) ? $outcomes[$barangayName]['FD'] : 0;

                                                if ($outcomeFilter == 'All') {
                                                    $outcomeText = 'All Outcomes';
                                                    $outcomeCount = $outcomeFTCount + $outcomePTCount + $outcomeFDCount;
                                                } else {
                                                    switch ($outcomeFilter) {
                                                        case 'FT':
                                                            $outcomeText = 'Full Term';
                                                            $outcomeCount = $outcomeFTCount;
                                                            break;
                                                        case 'PT':
                                                            $outcomeText = 'Pre-term';
                                                            $outcomeCount = $outcomePTCount;
                                                            break;
                                                        case 'FD':
                                                            $outcomeText = 'Fatal Death';
                                                            $outcomeCount = $outcomeFDCount;
                                                            break;
                                                        default:
                                                            $outcomeText = 'All Outcomes';
                                                            $outcomeCount = $outcomeFTCount + $outcomePTCount + $outcomeFDCount;
                                                            break;
                                                    }
                                                }

                                                echo "<tr>";
                                                echo "<td>" . $outcomeText . "</td>";
                                                echo "<td>" . $barangayName . "</td>";
                                                echo "<td>" . $outcomeCount . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('outcomeChart').getContext('2d');
    var outcomeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $barangays; ?>,  
            datasets: [
                {
                    label: 'Full Term (FT)',
                    data: <?php echo $outcomeFT; ?>, 
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                },
                {
                    label: 'Pre-term (PT)',
                    data: <?php echo $outcomePT; ?>, 
                    backgroundColor: 'rgba(255, 159, 64, 1)',
                },
                {
                    label: 'Fatal Death (FD)',
                    data: <?php echo $outcomeFD; ?>,
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: { stepSize: 4 },
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    onClick: function(e) {
                        e.stopPropagation(); 
                    }
                }
            }
        }
    });
</script>
<?php include('includes/footer.php'); ?>X
<?php include('includes/scripts.php'); ?>X
