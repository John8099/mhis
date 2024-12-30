<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
  header('Location: index.php');
  exit();
}
include('includes/header.php');
include('includes/rhu_navbar.php');


$results_per_page = 4;
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

if (!empty($search_query)) {
  $query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userType = 'BHS' AND (userFname LIKE '%$search_query%' OR userLname LIKE '%$search_query%')";
} else {
  $query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userType = 'BHS'";
}
$result = mysqli_query($conn, $query);
$number_of_results = mysqli_num_rows($result);
$number_of_pages = ceil($number_of_results / $results_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$this_page_first_result = ($current_page - 1) * $results_per_page;

if (!empty($search_query)) {
  $query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userType = 'BHS' AND (userFname LIKE '%$search_query%' OR userLname LIKE '%$search_query%') ORDER BY userLname ASC LIMIT $this_page_first_result, $results_per_page";
} else {
  $query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userType = 'BHS' ORDER BY userLname ASC LIMIT $this_page_first_result, $results_per_page ";
}

$query_run = mysqli_query($conn, $query);

$station_results_per_page = 4;
$station_current_page = isset($_GET['station_page']) ? $_GET['station_page'] : 1;
$station_this_page_first_result = ($station_current_page - 1) * $station_results_per_page;

$station_total_query = "SELECT * FROM station";
$station_total_result = mysqli_query($conn, $station_total_query);
$station_number_of_results = mysqli_num_rows($station_total_result);
$station_number_of_pages = ceil($station_number_of_results / $station_results_per_page);

$stationQuery = "SELECT * FROM station ORDER BY stationName ASC LIMIT $station_this_page_first_result, $station_results_per_page";
$stationResult = mysqli_query($conn, $stationQuery);

$barangay_results_per_page = 4;
$barangay_current_page = isset($_GET['barangay_page']) ? $_GET['barangay_page'] : 1;
$barangay_this_page_first_result = ($barangay_current_page - 1) * $barangay_results_per_page;

$barangay_total_query = "SELECT b.*, s.stationName FROM barangay b LEFT JOIN station s ON b.stationID = s.stationID";
$barangay_total_result = mysqli_query($conn, $barangay_total_query);
$barangay_number_of_results = mysqli_num_rows($barangay_total_result);
$barangay_number_of_pages = ceil($barangay_number_of_results / $barangay_results_per_page);

$barangayQuery = "SELECT b.*, s.stationName FROM barangay b LEFT JOIN station s ON b.stationID = s.stationID ORDER BY stationName ASC LIMIT $barangay_this_page_first_result, $barangay_results_per_page";
$barangayResult = mysqli_query($conn, $barangayQuery);

?>
<div class="container-fluid">
  <div class="row my-3">
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">Midwife Profiles</h5>
        </div>
        <div class="card-body">
          <form action="" method="GET" class="mb-3">
            <div class="input-group">
              <input type="text" name="search_query" class="form-control rounded-0" placeholder="Search for midwife..." value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
              <button type="submit" class="btn btn-primary rounded-pill ml-1">Search</button>
            </div>
          </form>
          <table class="table table-bordered text-center">
            <?php if (mysqli_num_rows($query_run) > 0) { ?>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Station</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($query_run)) { ?>
                  <tr>
                    <td><?php echo $row['userLname'] . ', ' .  $row['userFname']; ?></td>
                    <td><?php echo $row['stationName']; ?></td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modifyStation<?php echo $row['userID']; ?>">MODIFY</button>
                      </div>
                    </td>
                  </tr>
                  <!-- Modify Modal -->
                  <div class="modal fade" id="modifyStation<?php echo $row['userID']; ?>" tabindex="-1" aria-labelledby="modifyModalLabel<?php echo $row['userID']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="container">
                            <div class="d-flex justify-content-end">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <h4 class="font-weight-normal text-center">Modify Midwife</h4>
                            <form action="rhu-functions.php" method="post">
                              <input type="hidden" name="bhsID" value="<?php echo $row['userID']; ?>">
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="bhsFname" class="form-label">Midwife First Name:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <input type="text" class="form-control" id="bhsFname" name="bhsFname" value="<?php echo $row['userFname']; ?>" placeholder="BHS First Name" onkeyup="this.value = this.value.toUpperCase();" required>
                                </div>
                              </div>
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="bhsLname" class="form-label">Midwife Last Name:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <input type="text" class="form-control" id="bhsLname" name="bhsLname" value="<?php echo $row['userLname']; ?>" placeholder="BHS Last Name" onkeyup="this.value = this.value.toUpperCase();" required>
                                </div>
                              </div>
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="bhsContactNumber" class="form-label">Midwife Contact Number:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <input type="number" class="form-control" id="bhsContactNumber" name="bhsContactNumber" value="<?php echo $row['userContactNumber']; ?>" placeholder="BHS Contact Number" required>
                                </div>
                              </div>
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="bhsStation" class="form-label">Midwife Station:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <select name="bhsStation" class="form-control" required>
                                    <option disabled selected>Select Station</option>
                                    <?php
                                    $bhsStationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
                                    $bhsStationResult = mysqli_query($conn, $bhsStationQuery);

                                    while ($bhsStationRow = mysqli_fetch_assoc($bhsStationResult)) {
                                      $stationID = $bhsStationRow['stationID'];
                                      $stationName = $bhsStationRow['stationName'];

                                      $selected = ($stationID == $row['stationID']) ? 'selected' : '';

                                      echo "<option value=\"$stationID\" $selected>$stationName</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="bhsUname" class="form-label">Midwife Username:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <input type="text" class="form-control" id="bhsUname" name="bhsUname" value="<?php echo $row['userUname']; ?>" placeholder="BHS Username" required>
                                </div>
                              </div>
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="bhsPassword" class="form-label">Midwife Password:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <input type="text" class="form-control" id="bhsPassword" name="bhsPassword" value="<?php echo $row['userPassword']; ?>" placeholder="BHS Password" required>
                                </div>
                              </div>
                              <div class="row align-items-center my-2">
                                <div class="col-xl-3 col-lg-3 col-md-3">
                                  <label for="stationStatus" class="form-label">Station Status:</label>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9">
                                  <select name="stationStatus" class="form-control">
                                    <option value="1" <?php echo $row['isActive'] == 1 ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo $row['isActive'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                  </select>
                                </div>
                              </div>
                              <div class="text-end">
                                <button type="submit" class="btn btn-primary w-25" name="modifyBHS" role="button">
                                  <i class="fa-solid fa-check me-1"></i> Submit
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }
              } else { ?>
                <div class="text-center mt-4">
                  <h3>No record found.</h3>
                </div>
              <?php } ?>
              </tbody>
          </table>
          <?php if ($number_of_pages > 1) { ?>
            <div class="d-flex justify-content-center">
              <ul class="pagination">
                <?php
                for ($page = 1; $page <= $number_of_pages; $page++) {
                  $active_class = ($page == $current_page) ? 'active' : '';
                  echo '<li class="page-item ' . $active_class . '"><a class="page-link" href="rhu_management?page=' . $page . '&search_query=' . $search_query . '">' . $page . '</a></li>';
                }
                ?>
              </ul>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-primary">Station List</h5>
            </div>
            <div class="card-body">
              <table class="table table-bordered text-center">
                <?php if (mysqli_num_rows($stationResult) > 0) { ?>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($stationRow = mysqli_fetch_assoc($stationResult)) { ?>
                      <tr>
                        <td><?php echo $stationRow['stationName'] ?></td>
                        <td>
                          <p style="background-color: <?php echo $stationRow['isActive'] ? 'green' : 'orange'; ?>; color: white; padding: 5px; border-radius: 3px; margin: 0;">
                            <?php echo $stationRow['isActive'] ? 'Active' : 'Inactive'; ?>
                          </p>
                        </td>

                        <td>
                          <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modifyStation<?php echo $stationRow['stationID']; ?>">MODIFY</button>
                        </td>
                      </tr>

                      <!-- Modify Modal -->
                      <div class="modal fade" id="modifyStation<?php echo $stationRow['stationID']; ?>" tabindex="-1" aria-labelledby="modifyModalLabel<?php echo $stationRow['stationID']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="container">
                                <div class="d-flex justify-content-end">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <h4 class="font-weight-normal text-center">Modify Station</h4>
                                <form action="rhu-functions.php" method="post">
                                  <input type="hidden" name="stationID" value="<?php echo $stationRow['stationID']; ?>">
                                  <div class="row align-items-center my-2">
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                      <label for="stationName" class="form-label">Station Name:</label>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9">
                                      <input type="text" class="form-control" id="stationName" name="stationName" value="<?php echo $stationRow['stationName']; ?>" placeholder="Station Name" onkeyup="this.value = this.value.toUpperCase();" required>
                                    </div>
                                  </div>
                                  <div class="row align-items-center my-2">
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                      <label for="stationStatus" class="form-label">Station Status:</label>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9">
                                      <select name="stationStatus" class="form-control">
                                        <option value="1" <?php echo $stationRow['isActive'] == 1 ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $stationRow['isActive'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="text-end">
                                    <button type="submit" class="btn btn-primary w-25" name="modifyStation" role="button">
                                      <i class="fa-solid fa-check me-1"></i> Submit
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </tbody>
                <?php } else { ?>
                  <div class="text-center mt-4">
                    <h3>No record found.</h3>
                  </div>
                <?php } ?>
              </table>
              <?php if ($station_number_of_pages > 1) { ?>
                <div class="d-flex justify-content-center">
                  <ul class="pagination">
                    <?php
                    for ($station_page = 1; $station_page <= $station_number_of_pages; $station_page++) {
                      $station_active_class = ($station_page == $station_current_page) ? 'active' : '';
                      echo '<li class="page-item ' . $station_active_class . '"><a class="page-link" href="rhu_management?station_page=' . $station_page . '">' . $station_page . '</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-lg-6">

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-primary">Barangay List</h5>
            </div>
            <div class="card-body">
              <table class="table table-bordered text-center">
                <?php if (mysqli_num_rows($barangayResult) > 0) { ?>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Station Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($barangayRow = mysqli_fetch_assoc($barangayResult)) { ?>
                      <tr>
                        <td><?php echo $barangayRow['barangayName'] ?></td>
                        <td><?php echo $barangayRow['stationName'] ?></td>
                        <td>
                          <p style="background-color: <?php echo $barangayRow['isActive'] ? 'green' : 'orange'; ?>; color: white; padding: 5px; border-radius: 3px; margin: 0;">
                            <?php echo $barangayRow['isActive'] ? 'Active' : 'Inactive'; ?>
                          </p>
                        </td>

                        <td>
                          <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modifyBarangay<?php echo $barangayRow['barangayID']; ?>">MODIFY</button>
                        </td>
                      </tr>

                      <!-- Modify Modal -->
                      <div class="modal fade" id="modifyBarangay<?php echo $barangayRow['barangayID']; ?>" tabindex="-1" aria-labelledby="modifyModalLabel<?php echo $barangayRow['barangayID']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="container">
                                <div class="d-flex justify-content-end">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <h4 class="font-weight-normal text-center">Modify Barangay</h4>
                                <form action="rhu-functions.php" method="post">
                                  <input type="hidden" name="barangayID" value="<?php echo $barangayRow['barangayID']; ?>">
                                  <div class="row align-items-center my-2">
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                      <label for="barangayStation" class="form-label">Station:</label>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9">
                                      <select name="barangayStation" class="form-control">
                                        <option value="">Select Station</option>
                                        <?php
                                        $selectedStationID = $barangayRow['stationID'];

                                        $stationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
                                        $stationResult = mysqli_query($conn, $stationQuery);

                                        while ($row = mysqli_fetch_assoc($stationResult)) {
                                          $stationID   = $row['stationID'];
                                          $stationName = $row['stationName'];

                                          // Check if this stationID matches the selected stationID
                                          $selectedAttribute = ($stationID == $selectedStationID) ? 'selected' : '';

                                          echo "<option value=\"$stationID\" $selectedAttribute>$stationName</option>";
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row align-items-center my-2">
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                      <label for="barangayName" class="form-label">Barangay Name:</label>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9">
                                      <input type="text" class="form-control" id="barangayName" name="barangayName" value="<?php echo $barangayRow['barangayName']; ?>" placeholder="Barangay Name" onkeyup="this.value = this.value.toUpperCase();" required>
                                    </div>
                                  </div>
                                  <div class="row align-items-center my-2">
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                      <label for="barangayStatus" class="form-label">Barangay Status:</label>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9">
                                      <select name="barangayStatus" class="form-control">
                                        <option value="1" <?php echo $barangayRow['isActive'] == 1 ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $barangayRow['isActive'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="text-end">
                                    <button type="submit" class="btn btn-primary w-25" name="modifyBarangay" role="button">
                                      <i class="fa-solid fa-check me-1"></i> Submit
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </tbody>
                <?php } else { ?>
                  <div class="text-center mt-4">
                    <h3>No record found.</h3>
                  </div>
                <?php } ?>
              </table>
              <?php if ($barangay_number_of_pages > 1) { ?>
                <div class="d-flex justify-content-center">
                  <ul class="pagination">
                    <?php
                    $max_visible_pages = 5;
                    $start_page = max(1, $barangay_current_page - floor($max_visible_pages / 2));
                    $end_page = min($barangay_number_of_pages, $start_page + $max_visible_pages - 1);

                    if ($end_page - $start_page < $max_visible_pages - 1) {
                      $start_page = max(1, $end_page - $max_visible_pages + 1);
                    }

                    if ($barangay_current_page > 1) {
                      echo '<li class="page-item"><a class="page-link" href="rhu_management?barangay_page=' . ($barangay_current_page - 1) . '">Previous</a></li>';
                    }

                    for ($barangay_page = $start_page; $barangay_page <= $end_page; $barangay_page++) {
                      $barangay_active_class = ($barangay_page == $barangay_current_page) ? 'active' : '';
                      echo '<li class="page-item ' . $barangay_active_class . '"><a class="page-link" href="rhu_management?barangay_page=' . $barangay_page . '">' . $barangay_page . '</a></li>';
                    }

                    if ($barangay_current_page < $barangay_number_of_pages) {
                      echo '<li class="page-item"><a class="page-link" href="rhu_management?barangay_page=' . ($barangay_current_page + 1) . '">Next</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">Add Midwife</h5>
        </div>
        <div class="card-body">
          <form action="rhu-functions.php" method="post">
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="bhsFname" class="form-label">Midwife First Name:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="text" class="form-control" id="bhsFname" name="bhsFname" placeholder="Midwife First Name" onkeyup="this.value = this.value.toUpperCase();" required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="bhsLname" class="form-label">Midwife Last Name:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="text" class="form-control" id="bhsLname" name="bhsLname" placeholder="Midwife Last Name" onkeyup="this.value = this.value.toUpperCase();" required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="bhsContactNumber" class="form-label">Midwife Contact Number:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="text" class="form-control" id="bhsContactNumber" name="bhsContactNumber" placeholder="Midwife Contact Number" required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="bhsStation" class="form-label">Midwife Station:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9 position-relative">
                <select name="bhsStation" id="addBHSStation" class="form-control custom-select" onchange="toggleBHSButton()">
                  <option value="0" disabled selected>Select Station</option>
                  <?php
                  $stationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
                  $stationResult = mysqli_query($conn, $stationQuery);

                  while ($row = mysqli_fetch_assoc($stationResult)) {
                    $stationID   = $row['stationID'];
                    $stationName = $row['stationName'];
                    echo "<option value=\"$stationID\">$stationName</option>";
                  }
                  ?>
                </select>
                <span class="custom-arrow"></span>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="bhsUname" class="form-label">Midwife Username:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="text" class="form-control" id="bhsUname" name="bhsUname" placeholder="Midwife Username" required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="bhsPassword" class="form-label">Midwife Password:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="password" class="form-control" id="bhsPassword" name="bhsPassword" placeholder="Midwife Password" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="addBHS" id="addBHS" role="button" disabled>
              <i class="fa-solid fa-plus me-1"></i> Add Midwife
            </button>
          </form>
        </div>
      </div>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">Add Station</h5>
        </div>
        <div class="card-body">
          <form action="rhu-functions.php" method="post">
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="stationName" class="form-label">Station Name:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="text" class="form-control" id="stationName" name="stationName" placeholder="Station Name" onkeyup="this.value = this.value.toUpperCase();" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="addStation" role="button">
              <i class="fa-solid fa-plus me-1"></i> Add Station
            </button>
          </form>
        </div>
      </div>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">Add Barangay</h5>
        </div>
        <div class="card-body">
          <form action="rhu-functions.php" method="post">
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="barangayStation" class="form-label">Station:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9 position-relative">
                <select name="barangayStation" class="form-select" id="addStationBarangay" onchange="toggleBarangayButton()">
                  <option value="0" disabled selected>Select Station</option>
                  <?php
                  $stationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
                  $stationResult = mysqli_query($conn, $stationQuery);

                  while ($row = mysqli_fetch_assoc($stationResult)) {
                    $stationID   = $row['stationID'];
                    $stationName = $row['stationName'];

                    echo "<option value=\"$stationID\">$stationName</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-3 col-lg-3 col-md-3">
                <label for="barangayName" class="form-label">Barangay Name:</label>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-9">
                <input type="text" class="form-control" id="barangayName" name="barangayName" placeholder="Barangay Name" onkeyup="this.value = this.value.toUpperCase();" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="addBarangay" id="addBarangay" role="button" disabled>
              <i class="fa-solid fa-plus me-1"></i> Add Barangay
            </button>
          </form>
        </div>
      </div>

      <style>
        /* Dropdown arrow styling */
        .dropdown-arrow {
          position: absolute;
          right: 15px;
          top: 50%;
          transform: translateY(-50%);
          pointer-events: none;
          width: 0;
          height: 0;
          border-left: 8px solid transparent;
          border-right: 8px solid transparent;
          border-top: 10px solid #6c757d;
          /* Color of the arrow */
        }
      </style>


      <script>
        function toggleBarangayButton() {
          var station = document.getElementById('addStationBarangay');
          var addBarangay = document.getElementById('addBarangay');

          if (station.value == 0) {
            addBarangay.disabled = true;
          } else {
            addBarangay.disabled = false;
          }
        }

        function toggleBHSButton() {
          var bhs_station = document.getElementById('addBHSStation');
          var addBHS = document.getElementById('addBHS');

          if (bhs_station.value == 0) {
            addBHS.disabled = true;
          } else {
            addBHS.disabled = false;
          }
        }
      </script>
      <?php
      include('includes/scripts.php');
      include('includes/footer.php');
      ?>