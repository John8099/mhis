<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
  header('Location: index.php');
  exit();
}

include('includes/header.php');
include('includes/rhu_navbar.php');

$categoryNames = [
  "iron" => "Iron Sulfate",
  "calcium" => "Calcium Carbonate",
  "iodine" => "Iodine Capsule",
  "deworming" => "Deworming"
];
?>
<style>
  .card-body.card-table {
    height: 530px;
  }

  .card-table nav {
    bottom: 0;
    position: absolute;
    width: 100%;
  }
</style>

<div class="container-fluid">
  <div class="row my-3">
    <div class="col-lg-6">
      <div class="card shadow my-2">
        <div class="card-header">
          <h5 class="m-0 font-weight-bold text-primary">Added</h5>
        </div>
        <div class="card-body card-table">
          <form method="GET" class="mb-3">
            <div class="input-group">
              <input type="text" class="form-control" name="added_search" placeholder="Search Medicine">
              <button type="submit" class="btn btn-primary">Search</button>
              <button type="button" class="btn btn-secondary" onclick="window.location.href = 'rhu_inventory_history'">Clear</button>
            </div>
          </form>

          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>Medicine Name</th>
                <th>Medicine Category</th>
                <th>Stocks Added</th>
                <th>Date Added</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = 5;
              $page = isset($_GET['added_page']) ? (int)$_GET['added_page'] : 1;
              $start = ($page - 1) * $limit;

              $search = isset($_GET['added_search']) ? mysqli_real_escape_string($conn, $_GET['added_search']) : '';

              $addedQuery = "SELECT 
                                i.*,
                                m.medicineName,
                                m.medicineCategory
                              FROM rhu_inventory_history i
                              LEFT JOIN medicine m
                              ON m.medicineID = i.medicine_id
                              WHERE m.medicineName LIKE '%$search%'
                              AND i.category = 'added'
                              ORDER BY i.date_added DESC
                              LIMIT $start, $limit";
              $addedResult = mysqli_query($conn, $addedQuery);

              $totalQuery = "SELECT 
                                COUNT(*)
                              FROM rhu_inventory_history i
                              LEFT JOIN medicine m
                              ON m.medicineID = i.medicine_id
                              WHERE m.medicineName LIKE '%$search%'
                              AND i.category = 'added'";

              $totalResult = mysqli_query($conn, $totalQuery);
              $totalRecords = mysqli_fetch_array($totalResult)[0];
              $totalPages = ceil($totalRecords / $limit);

              while ($addedRow = mysqli_fetch_object($addedResult)):
              ?>
                <tr>
                  <td><?= $addedRow->medicineName ?></td>
                  <td><?= isset($categoryNames[$addedRow->medicineCategory]) ? $categoryNames[$addedRow->medicineCategory] : $addedRow->medicineCategory; ?></td>
                  <td><?= $addedRow->quantity; ?></td>
                  <td><?= date("F j, Y", strtotime($addedRow->date_added)); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <nav aria-label="Page navigation">
            <?php if ($totalPages > 1) : ?>
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?added_page=<?= $i; ?>&added_search=<?= urlencode($search); ?>"><?= $i; ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            <?php endif; ?>
          </nav>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow my-2">
        <div class="card-header">
          <h5 class="m-0 font-weight-bold text-primary">Distributed</h5>
        </div>
        <div class="card-body  card-table">
          <form method="GET" class="mb-3">
            <div class="input-group">
              <input type="text" class="form-control" name="distributed_search" placeholder="Search BHS or Medicine">
              <button type="submit" class="btn btn-primary">Search</button>
              <button type="button" class="btn btn-secondary" onclick="window.location.href = 'rhu_inventory_history'">Clear</button>
            </div>
          </form>

          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>BHS Name</th>
                <th>Medicine Name</th>
                <th>Stocks Given</th>
                <th>Date Given</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = 5;
              $page = isset($_GET['distributed_page']) ? (int)$_GET['distributed_page'] : 1;
              $start = ($page - 1) * $limit;

              $search = isset($_GET['distributed_search']) ? mysqli_real_escape_string($conn, $_GET['distributed_search']) : '';

              $distributedQuery = "SELECT 
                                    i.*,
                                    s.stationName,
                                    m.medicineName,
                                    m.medicineCategory
                                    FROM rhu_inventory_history i
                                    LEFT JOIN medicine m
                                    ON m.medicineID = i.medicine_id
                                    LEFT JOIN station s
                                    ON s.stationID = i.station_id
                                    WHERE s.stationName LIKE '%$search%' OR m.medicineName LIKE '%$search%' 
                                    AND i.category = 'distributed'
                                    ORDER BY i.date_added DESC LIMIT $start, $limit";

              $distributedResult = mysqli_query($conn, $distributedQuery);

              $totalQuery = "SELECT 
                              COUNT(*)
                              FROM rhu_inventory_history i
                              LEFT JOIN medicine m
                              ON m.medicineID = i.medicine_id
                              LEFT JOIN station s
                              ON s.stationID = i.station_id
                              WHERE s.stationName LIKE '%$search%' OR m.medicineName LIKE '%$search%' 
                              AND i.category = 'distributed'";

              $totalResult = mysqli_query($conn, $totalQuery);
              $totalRecords = mysqli_fetch_array($totalResult)[0];
              $totalPages = ceil($totalRecords / $limit);

              while ($distributedRow = mysqli_fetch_object($distributedResult)):
              ?>
                <tr>
                  <td><?= $distributedRow->stationName; ?></td>
                  <td><?= $distributedRow->medicineName; ?></td>
                  <td><?= $distributedRow->quantity; ?></td>
                  <td><?= date("F j, Y", strtotime($distributedRow->date_added)); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <nav aria-label="Page navigation">
            <?php if ($totalPages > 1) { ?>
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?distributed_page=<?= $i; ?>&distributed_search=<?= urlencode($search); ?>"><?= $i; ?></a>
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