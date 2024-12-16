<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
    header('Location: index.php');
    exit();
}

include('includes/header.php');
include('includes/midwife_navbar.php');

$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $stationID = $user_data['stationID'];
}
?>

<div class="container-fluid">
    <div class="row my-3">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary"><?php echo $user_data['stationName']; ?> Patient Profiles</h5>
                </div>
                <div class="card-body">
                    <form action="" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search_query" class="form-control rounded-0" placeholder="Search for patient..." value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
                            <button type="submit" class="btn btn-primary rounded-pill ml-1">Search</button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end my-3">
                        <form action="" method="GET" class="form-inline">
                            <select name="status_filter" class="form-select" onchange="this.form.submit()">
                                <option value="">ALL</option>
                                <option value="Complete" <?php echo isset($_GET['status_filter']) && $_GET['status_filter'] === "Complete" ? 'selected' : ''; ?>>Complete</option>
                                <option value="In Progress" <?php echo isset($_GET['status_filter']) && $_GET['status_filter'] === "In Progress" ? 'selected' : ''; ?>>In Progress</option>
                            </select>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <?php
                        $results_per_page = 10;
                        $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
                        $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

                        $query = "SELECT p.*, 
                                         b.barangayName, 
                                         IF(
                                            pro.poTerminatedDate IS NOT NULL AND 
                                            pro.poOutcome IS NOT NULL AND 
                                            pro.poBabySex IS NOT NULL AND 
                                            pro.poBabyWeight IS NOT NULL AND 
                                            pro.poDeliveryType IS NOT NULL AND 
                                            pro.poPlaceType IS NOT NULL AND 
                                            pro.poBirthAttendant IS NOT NULL AND 
                                            pro.poDeliveryDate IS NOT NULL AND 
                                            pro.poDeliveryTime IS NOT NULL, 
                                            'Complete', 'In Progress') AS status
                                  FROM patient p 
                                  LEFT JOIN barangay b ON p.barangayID = b.barangayID 
                                  LEFT JOIN calcium_info cal ON p.patientID = cal.patientID 
                                  LEFT JOIN deworming_info dew ON p.patientID = dew.patientID 
                                  LEFT JOIN infectious inf ON p.patientID = inf.patientID 
                                  LEFT JOIN laboratory lab ON p.patientID = lab.patientID 
                                  LEFT JOIN micronutrient_info mic ON p.patientID = mic.patientID 
                                  LEFT JOIN `pre-natal_info` prn ON p.patientID = prn.patientID 
                                  LEFT JOIN pregnancy_outcome pro ON p.patientID = pro.patientID 
                                  LEFT JOIN tetanus_info tet ON p.patientID = tet.patientID 
                                  WHERE b.stationID = '$stationID'";

                        if (!empty($search_query)) {
                            $query .= " AND (patientFname LIKE '%$search_query%' 
                                            OR patientMname LIKE '%$search_query%' 
                                            OR patientLname LIKE '%$search_query%' 
                                            OR patientSerialNumber LIKE '%$search_query%' 
                                            OR barangayName LIKE '%$search_query%')";
                        }

                        $completion_conditions = "
                            pro.poTerminatedDate IS NOT NULL AND pro.poOutcome IS NOT NULL AND 
                            pro.poBabySex IS NOT NULL AND pro.poBabyWeight IS NOT NULL AND 
                            pro.poDeliveryType IS NOT NULL AND pro.poPlaceType IS NOT NULL AND 
                            pro.poBirthAttendant IS NOT NULL AND pro.poDeliveryDate IS NOT NULL AND 
                            pro.poDeliveryTime IS NOT NULL";

                        if ($status_filter === "Complete") {
                            $query .= " AND ($completion_conditions)";
                        } elseif ($status_filter === "In Progress") {
                            $query .= " AND NOT ($completion_conditions)";
                        }

                        $total_results = mysqli_query($conn, $query);
                        $total_rows = mysqli_num_rows($total_results);
                        $total_pages = ceil($total_rows / $results_per_page);

                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($current_page - 1) * $results_per_page;

                        $query .= " ORDER BY patientID DESC LIMIT $offset, $results_per_page";
                        $result = mysqli_query($conn, $query);
                        
                        ?>

                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Patient Serial Number</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Barangay</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['patientSerialNumber']; ?></td>
                                        <td><?php echo htmlspecialchars($row['patientFname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['patientMname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['patientLname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['barangayName']); ?></td>
                                        <td>
                                            <p style="background-color: <?php echo $row['status'] == 'Complete' ? 'green' : ($row['status'] == 'In Progress' ? 'orange' : 'white'); ?>; color: white; padding: 5px; border-radius: 3px; margin: 0;">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </p>
                                        </td>
                                        <td>
                                            <a href="bhs_patient-view?id=<?php echo $row['patientID']; ?>" class="btn btn-primary">View</a>
                                            <a href="bhs_patient-edit?id=<?php echo $row['patientID']; ?>" class="btn btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <div class="d-flex justify-content-center">
                                <ul class="pagination">
                                    <?php
                                    for ($page = 1; $page <= $total_pages; $page++):
                                        $active_class = ($page == $current_page) ? 'active' : ''; ?>
                                        <li class="page-item <?php echo $active_class; ?>">
                                            <a class="page-link" href="bhs_patient-records?page=<?php echo $page; ?>&search_query=<?php echo urlencode($search_query); ?>&status_filter=<?php echo $status_filter; ?>">
                                                <?php echo $page; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>