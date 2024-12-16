<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
    header('Location: index.php');
    exit();
}

include('includes/header.php');
include('includes/rhu_navbar.php');

?>

<div class="container-fluid">
    <div class="row my-3">
        <div class="col-lg-6">
            <div class="card shadow my-2">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Medicine Inventory</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="medicine_search" placeholder="Search Medicine">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Medicine Name</th>
                                <th>Medicine Category</th>
                                <th>Available Stocks</th>
                                <th>Date Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $limit = 5; 
                                $page = isset($_GET['medicine_page']) ? (int)$_GET['medicine_page'] : 1; 
                                $start = ($page - 1) * $limit; 

                                $search = isset($_GET['medicine_search']) ? mysqli_real_escape_string($conn, $_GET['medicine_search']) : '';

                                $medicineQuery = "SELECT * FROM medicine WHERE medicineName LIKE '%$search%' ORDER BY dateUpdate DESC LIMIT $start, $limit";
                                $medicineResult = mysqli_query($conn, $medicineQuery);

                                $categoryNames = [
                                    "iron" => "Iron Sulfate",
                                    "calcium" => "Calcium Carbonate",
                                    "iodine" => "Iodine Capsule",
                                    "deworming" => "Deworming"
                                ];

                                $totalQuery = "SELECT COUNT(*) FROM medicine WHERE medicineName LIKE '%$search%'";
                                $totalResult = mysqli_query($conn, $totalQuery);
                                $totalRecords = mysqli_fetch_array($totalResult)[0];
                                $totalPages = ceil($totalRecords / $limit);

                                while ($medicineRow = mysqli_fetch_assoc($medicineResult)){
                                    $medicineID = $medicineRow['medicineID'];
                                    $medicineName = $medicineRow['medicineName'];
                                    $medicineCategory = $medicineRow['medicineCategory'];
                                    $medicineStock = $medicineRow['medicineStock'];
                                    $dateUpdate = $medicineRow['dateUpdate'];
                            ?>
                            <tr>
                                <td><?php echo $medicineName;?></td>
                                <td><?php echo isset($categoryNames[$medicineCategory]) ? $categoryNames[$medicineCategory] : $medicineCategory; ?></td>
                                <td><?php echo $medicineStock;?></td>
                                <td><?php echo date("F j, Y", strtotime($dateUpdate)); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modifyMedicine<?php echo $medicineID; ?>">Update</button>
                                </td>

                                <!-- Modify Modal -->
                                <div class="modal fade" id="modifyMedicine<?php echo $medicineID; ?>" tabindex="-1" aria-labelledby="modifyModalLabel<?php echo $medicineID; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <h4 class="font-weight-normal text-center">Modify Medicine</h4>
                                                    <form action="rhu-functions.php" method="post">
                                                        <input type="hidden" name="medicineID" value="<?php echo $medicineID; ?>">
                                                        <div class="row align-items-center my-2">
                                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                                <label for="medicineName" class="form-label">Medicine Name:</label>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                                <input type="text" class="form-control" id="medicineName" name="medicineName" value="<?php echo $medicineName ?>" placeholder="Medicine Name" required>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center my-2">
                                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                                <label for="medicineCategory" class="form-label">Medicine Category:</label>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                                <select name="medicineCategory" class="form-control">
                                                                    <option value="0" disabled selected>Select Type of Medicine</option>
                                                                    <option value="iron" <?php echo ($medicineCategory == 'iron') ? 'selected' : ''; ?>>Iron Sulfate</option>
                                                                    <option value="calcium" <?php echo ($medicineCategory == 'calcium') ? 'selected' : ''; ?>>Calcium Carbonate</option>
                                                                    <option value="iodine" <?php echo ($medicineCategory == 'iodine') ? 'selected' : ''; ?>>Iodine Capsule</option>
                                                                    <option value="deworming" <?php echo ($medicineCategory == 'deworming') ? 'selected' : ''; ?>>Deworming</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center my-2">
                                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                                <label for="medicineStock" class="form-label">Available Stock:</label>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                                <input type="text" class="form-control" id="medicineStock" name="medicineStock" value="<?php echo $medicineStock ?>" placeholder="Available Stock" required>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary w-25" name="modifyMedicine" role="button">
                                                                <i class="fa-solid fa-check me-1"></i> Submit
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <?php if ($totalPages > 1) { ?>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?medicine_page=<?php echo $i; ?>&medicine_search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        <?php } ?>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow my-2">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Barangay Health Station Distribution</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="inventory_search" placeholder="Search BHS or Medicine">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>BHS Name</th>
                                <th>Medicine Name</th>
                                <th>Stocks Given</th>
                                <th>Date Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $limit = 5; 
                                $page = isset($_GET['inventory_page']) ? (int)$_GET['inventory_page'] : 1; 
                                $start = ($page - 1) * $limit; 

                                $search = isset($_GET['inventory_search']) ? mysqli_real_escape_string($conn, $_GET['inventory_search']) : '';

                                $inventoryQuery = "SELECT i.*, s.stationName, m.medicineName 
                                                FROM inventory i 
                                                LEFT JOIN station s ON i.stationID = s.stationID 
                                                LEFT JOIN medicine m ON i.medicineID = m.medicineID 
                                                WHERE s.stationName LIKE '%$search%' OR m.medicineName LIKE '%$search%' 
                                                ORDER BY i.dateUpdate DESC LIMIT $start, $limit";
                                $inventoryResult = mysqli_query($conn, $inventoryQuery);

                                $totalQuery = "SELECT COUNT(*) FROM inventory i 
                                            LEFT JOIN station s ON i.stationID = s.stationID 
                                            LEFT JOIN medicine m ON i.medicineID = m.medicineID 
                                            WHERE s.stationName LIKE '%$search%' OR m.medicineName LIKE '%$search%'";
                                $totalResult = mysqli_query($conn, $totalQuery);
                                $totalRecords = mysqli_fetch_array($totalResult)[0];
                                $totalPages = ceil($totalRecords / $limit);

                                while ($inventoryRow = mysqli_fetch_assoc($inventoryResult)) {
                                    $bhsName = $inventoryRow['stationName'];
                                    $medicineName = $inventoryRow['medicineName'];
                                    $stocksGiven = $inventoryRow['availableStock'];
                                    $dateUpdate = $inventoryRow['dateUpdate'];
                            ?>
                            <tr>
                                <td><?php echo $bhsName; ?></td>
                                <td><?php echo $medicineName; ?></td>
                                <td><?php echo $stocksGiven; ?></td>
                                <td><?php echo date("F j, Y", strtotime($dateUpdate)); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modifyInventory<?php echo $inventoryRow['inventoryID']; ?>">Update</button>
                                </td>

                                <!-- Modify Modal -->
                                <div class="modal fade" id="modifyInventory<?php echo $inventoryRow['inventoryID']; ?>" tabindex="-1" aria-labelledby="modifyModalLabel<?php echo $inventoryRow['inventoryID']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <h4 class="font-weight-normal text-center">Modify Inventory</h4>
                                                    <form action="rhu-functions.php" method="post">
                                                        <input type="hidden" name="inventoryID" value="<?php echo $inventoryRow['inventoryID']; ?>">
                                                        <div class="row align-items-center my-2">
                                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                                <label for="bhsName" class="form-label">BHS Name:</label>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                                <input type="text" class="form-control" id="bhsName" name="bhsName" value="<?php echo $bhsName; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center my-2">
                                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                                <label for="medicineName" class="form-label">Medicine Name:</label>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                                <input type="text" class="form-control" id="medicineName" name="medicineName" value="<?php echo $medicineName; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center my-2">
                                                            <div class="col-xl-3 col-lg-3 col-md-3">
                                                                <label for="stockDistribution" class="form-label">Stocks Given:</label>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9">
                                                                <input type="text" class="form-control" id="stockDistribution" name="stockDistribution" value="<?php echo $stocksGiven; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary w-25" name="modifyInventory" role="button">
                                                                <i class="fa-solid fa-check me-1"></i> Submit
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <?php if ($totalPages > 1) { ?>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?inventory_page=<?php echo $i; ?>&inventory_search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        <?php } ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2">
        <div class="col-lg-6">
            <div class="card shadow my-2">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Add Medicine</h5>
                </div>
                <div class="card-body">
                    <form action="rhu-functions.php" method="post">
                        <div class="row align-items-center my-2">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <label for="medicineName" class="form-label">Medicine Name:</label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <input type="text" class="form-control" id="medicineName" name="medicineName" placeholder="Medicine Name" required>
                            </div>
                        </div>
                        <div class="row align-items-center my-2">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <label for="medicineCategory" class="form-label">Medicine Category:</label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <select name="medicineCategory" class="form-control">
                                    <option value="0" disabled selected>Select Type of Medicine</option>
                                    <option value="iron">Iron Sulfate</option>
                                    <option value="calcium">Calcium Carbonate</option>
                                    <option value="iodine">Iodine Capsule</option>
                                    <option value="deworming">Deworming</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center my-2">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <label for="medicineStock" class="form-label">Available Stock:</label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <input type="text" class="form-control" id="medicineStock" name="medicineStock" placeholder="Medicine Available Stock" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary w-25" name="addMedicine" role="button">
                                <i class="fa-solid fa-check me-1"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow my-2">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Barangay Health Station Medicine Distribution</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row align-items-center my-2">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <label for="stationID" class="form-label">BHS Name:</label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <select name="stationID" class="form-control" onchange="this.form.submit()">
                                    <option value="0" disabled selected>Select Barangay Health Station</option>
                                    <?php
                                        // Check if stationID is set after form submission
                                        $selectedStation = isset($_POST['stationID']) ? $_POST['stationID'] : ''; 

                                        // Query to fetch station names
                                        $stationQuery = "SELECT * FROM station WHERE isActive = 1 ORDER BY stationName ASC";
                                        $stationResult = mysqli_query($conn, $stationQuery);

                                        while ($stationRow = mysqli_fetch_assoc($stationResult)) {
                                            $stationID = $stationRow['stationID'];
                                            $stationName = $stationRow['stationName'];
                                            
                                            // Mark the selected station
                                            $selected = ($stationID == $selectedStation) ? 'selected' : '';
                                            
                                            echo "<option value=\"$stationID\" $selected>$stationName</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <form action="rhu-functions.php" method="post">
                        <input type="hidden" name="stationID" value="<?php echo isset($_POST['stationID']) ? $_POST['stationID'] : ''; ?>">
                        <div class="row align-items-center my-2">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <label for="medicineID" class="form-label">Medicine Name:</label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <select name="medicineID" class="form-control" id="medicineID">
                                    <option value="0" disabled selected>Select Medicine</option>
                                    <?php
                                        if (isset($_POST['stationID']) && $_POST['stationID'] > 0) {
                                            $selectedStationID = $_POST['stationID'];
                                            $medicineBHSQuery = "
                                                SELECT m.* 
                                                FROM medicine m
                                                LEFT JOIN inventory i ON m.medicineID = i.medicineID AND i.stationID = '$selectedStationID'
                                                WHERE m.medicineStock > 0 AND i.medicineID IS NULL
                                                ORDER BY m.medicineName ASC";
                                            $medicineBHSResult = mysqli_query($conn, $medicineBHSQuery);
                    
                                            while ($medicineBHSRow = mysqli_fetch_assoc($medicineBHSResult)) {
                                                $medicineID = $medicineBHSRow['medicineID'];
                                                $medicineStock = $medicineBHSRow['medicineStock'];
                                                $medicineName = $medicineBHSRow['medicineName'];
                                                $selected = (isset($_POST['medicineID']) && $medicineID == $_POST['medicineID']) ? 'selected' : '';
                    
                                                echo "<option value=\"$medicineID\" data-stock=\"$medicineStock\" $selected>$medicineName</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center my-2">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <label for="stockDistribution" class="form-label">Stock Distribution:</label>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <input type="number" class="form-control" id="stockDistribution" name="stockDistribution" placeholder="Enter stock distribution" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary w-25" name="addInventory" role="button">
                                <i class="fa-solid fa-check me-1"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>