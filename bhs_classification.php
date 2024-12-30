<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
  header('Location: index.php');
  exit();
}

include('includes/header.php');
include('includes/midwife_navbar.php');
$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationID 
          FROM user u 
          LEFT JOIN station s ON u.stationID = s.stationID 
          WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $user_data = mysqli_fetch_assoc($result);
  $stationID = $user_data['stationID'];
}

$outcomeFilter = isset($_GET['outcomeFilter']) ? $_GET['outcomeFilter'] : '';

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
    WHERE 
        b.stationID = '$stationID'";

if ($outcomeFilter) {
  $query .= " AND po.poOutcome = '$outcomeFilter'";
}

$query .= " GROUP BY b.barangayName, po.poOutcome
            ORDER BY b.barangayName, po.poOutcome";

$result = mysqli_query($conn, $query);

$barangays = [];
$outcomeFT = [];
$outcomePT = [];
$outcomeFD = [];

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

foreach ($barangays as $barangay) {
  if (!in_array($barangay, array_keys($outcomeFT))) {
    $outcomeFT[] = 0;
  }
  if (!in_array($barangay, array_keys($outcomePT))) {
    $outcomePT[] = 0;
  }
  if (!in_array($barangay, array_keys($outcomeFD))) {
    $outcomeFD[] = 0;
  }
}

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
                    <th>Barangay Name</th>
                    <th>Total Number</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = mysqli_query($conn, $query);
                  $barangay_outcomes = [];

                  if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $barangay_outcomes[$row['barangayName']][$row['poOutcome']] = $row['outcomeCount'];
                    }
                  }

                  $barangay_query = "SELECT barangayName FROM barangay WHERE stationID = '$stationID' ORDER BY barangayName";
                  $barangay_result = mysqli_query($conn, $barangay_query);

                  if ($barangay_result && mysqli_num_rows($barangay_result) > 0) {
                    while ($barangay = mysqli_fetch_assoc($barangay_result)) {
                      $barangayName = $barangay['barangayName'];
                      $outcomeFTCount = isset($barangay_outcomes[$barangayName]['FT']) ? $barangay_outcomes[$barangayName]['FT'] : 0;
                      $outcomePTCount = isset($barangay_outcomes[$barangayName]['PT']) ? $barangay_outcomes[$barangayName]['PT'] : 0;
                      $outcomeFDCount = isset($barangay_outcomes[$barangayName]['FD']) ? $barangay_outcomes[$barangayName]['FD'] : 0;

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

                      echo "<tr>";
                      echo "<td>" . $outcomeText . "</td>";
                      echo "<td>" . $barangayName . "</td>";
                      echo "<td>" . $outcomeCount . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='3'>No data found</td></tr>";
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
      datasets: [{
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
          ticks: {
            stepSize: 4
          },
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

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>