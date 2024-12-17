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

$search = isset($_GET['inventory_search']) ? mysqli_real_escape_string($conn, $_GET['inventory_search']) : '';
?>

<div class="container-fluid w-75">
  <div class="row my-3">
    <div class="col-lg-12">
      <div class="card shadow my-2">
        <div class="card-header">
          <h5 class="m-0 font-weight-bold text-primary"><?php echo $stationName; ?> Inventory History</h5>
        </div>
        <div class="card-body">
          <form method="GET" class="mb-3">
            <div class="input-group">
              <input type="text" class="form-control" name="inventory_search" value="<?= $search ?>" placeholder="Search Medicine">
              <button type="submit" class="btn btn-primary">Search</button>
              <button type="button" class="btn btn-secondary" onclick="window.location.href = 'bhs_inventory_history'">Clear</button>
            </div>
          </form>
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>Inventory Name</th>
                <th>Inventory Category</th>
                <th>Patient</th>
                <th>Quantity</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = 5;
              $page = isset($_GET['inventory_history_page']) ? (int)$_GET['inventory_history_page'] : 1;
              $start = ($page - 1) * $limit;


              $inventoryHistoryQ = mysqli_query(
                $conn,
                "SELECT 
                  m.medicineName,
                  m.medicineCategory,
                  CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName,
                  ih.quantity,
                  ih.date_created
                FROM inventory_history ih
                LEFT JOIN medicine m
                ON ih.medicine_id = m.medicineID
                LEFT JOIN patient p
                ON ih.patient_id = p.patientID
                WHERE m.medicineName LIKE '%$search%'
                ORDER BY ih.date_created DESC 
                LIMIT $start, $limit"
              );

              $totalResult = mysqli_query(
                $conn,
                "SELECT 
                  COUNT(*), m.medicineName 
                FROM inventory_history ih
                LEFT JOIN medicine m
                ON ih.medicine_id = m.medicineID
                LEFT JOIN patient p
                ON ih.patient_id = p.patientID
                WHERE m.medicineName LIKE '%$search%'"
              );

              $totalRecords = mysqli_fetch_array($totalResult)[0];
              $totalPages = ceil($totalRecords / $limit);

              while ($res = mysqli_fetch_object($inventoryHistoryQ)):
                $categoryNames = [
                  "iron" => "Iron Sulfate",
                  "calcium" => "Calcium Carbonate",
                  "iodine" => "Iodine Capsule",
                  "deworming" => "Deworming"
                ];
              ?>
                <tr>
                  <td><?= $res->medicineName ?></td>
                  <td><?= $categoryNames[$res->medicineCategory] ?></td>
                  <td><?= $res->patientName ?></td>
                  <td><?= $res->quantity ?></td>
                  <td><?= date("F d, Y", strtotime($res->date_created)) ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <nav aria-label="Page navigation">
            <?php if ($totalPages > 1) { ?>
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?inventory_history_page=<?php echo $i; ?>&inventory_search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
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