<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
    header('Location: index.php');
    exit();
}

include('includes/header.php');
include('includes/midwife_navbar.php');

$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationID, s.stationName
          FROM user u 
          LEFT JOIN station s ON u.stationID = s.stationID 
          WHERE userUname = '$username' AND userType = 'BHS'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $stationID = $user_data['stationID'];
    $stationName = $user_data['stationName'];
}

?>

<div class="container-fluid w-75">
    <div class="row my-3">
        <div class="col-lg-12">
            <div class="card shadow my-2">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary"><?php echo $stationName;?> Inventory</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="inventory_search" placeholder="Search Medicine">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Inventory Name</th>
                                <th>Inventory Category</th>
                                <th>Available Stocks</th>
                                <th>Last Date Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $limit = 5; 
                                $page = isset($_GET['inventory_page']) ? (int)$_GET['inventory_page'] : 1;
                                $start = ($page - 1) * $limit; 

                                $search = isset($_GET['inventory_search']) ? mysqli_real_escape_string($conn, $_GET['inventory_search']) : '';

                                // Change to ASC to show oldest entries first
                                $inventoryQuery = "SELECT i.*, m.medicineName, m.medicineCategory 
                                                   FROM inventory i 
                                                   LEFT JOIN medicine m ON i.medicineID = m.medicineID 
                                                   WHERE m.medicineName LIKE '%$search%' AND i.stationID = '$stationID' 
                                                   ORDER BY dateUpdate ASC 
                                                   LIMIT $start, $limit";
                                $inventoryResult = mysqli_query($conn, $inventoryQuery);

                                $categoryNames = [
                                    "iron" => "Iron Sulfate",
                                    "calcium" => "Calcium Carbonate",
                                    "iodine" => "Iodine Capsule",
                                    "deworming" => "Deworming"
                                ];

                                $totalQuery = "SELECT COUNT(*), m.medicineName 
                                               FROM inventory i 
                                               LEFT JOIN medicine m ON i.medicineID = m.medicineID 
                                               WHERE m.medicineName LIKE '%$search%'";

                                $totalResult = mysqli_query($conn, $totalQuery);
                                $totalRecords = mysqli_fetch_array($totalResult)[0];
                                
                                $totalPages = ceil($totalRecords / $limit);

                                while ($inventoryRow = mysqli_fetch_assoc($inventoryResult)) {
                                    $inventoryID = $inventoryRow['inventoryID'];
                                    $medicineName = $inventoryRow['medicineName'];
                                    $medicineCategory = $inventoryRow['medicineCategory'];
                                    $availableStock = $inventoryRow['availableStock'];
                                    $dateUpdate = $inventoryRow['dateUpdate'];
                            ?>
                                <tr>
                                    <td><?php echo $medicineName;?></td>
                                    <td><?php echo isset($categoryNames[$medicineCategory]) ? $categoryNames[$medicineCategory] : $medicineCategory; ?></td>
                                    <td><?php echo $availableStock;?></td>
                                    <td><?php echo date("F j, Y", strtotime($dateUpdate)); ?></td>
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
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>