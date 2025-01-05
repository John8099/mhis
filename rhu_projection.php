<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "RHU") {
  header('Location: index.php');
  exit();
}

include('includes/header.php');
include('includes/rhu_navbar.php');

$username = $_SESSION['user'];

$query = "SELECT u.*, s.stationName FROM user u LEFT JOIN station s ON u.stationID = s.stationID WHERE userUname = '$username' AND userType = 'RHU'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $user_data = mysqli_fetch_assoc($result);
  $stationID = $user_data['stationID'];
}

$lastMonth = date("F", strtotime("last month"));
?>

<div class="container-fluid">
  <div class="row my-3">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h5 class="m-0 font-weight-bold text-primary">
            Medicine Projection
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover text-center" id="table-patient-records">
              <thead>
                <tr>
                  <th>BHS Name</th>
                  <th>Medicine Name</th>
                  <th>Medicine Category</th>
                  <th>BHS Stocks</th>
                  <th>Needed</th>
                  <th>To Add</th>
                  <th>Current</th>
                  <th>Date Period</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $startDate = date("Y-m-d", strtotime("first day of this month"));
                $endDate = date("Y-m-t", strtotime('+3 month', strtotime($startDate)));

                $formattedDatePeriodStart = date('M Y', strtotime($startDate));
                $formattedDatePeriodEnd = date('M Y', strtotime('+3 month', strtotime($startDate)));

                $projectionQuery = "SELECT 
                                      b.barangayID,
                                      s.stationID,
                                      b.barangayName,
                                      s.stationName,
                                      tmp.patient_id,
                                      tmp.med_name,
                                      SUM(tmp.tab) AS 'needed',
                                      tmp.sched_date,
                                      tmp.status
                                    FROM (
                                      SELECT 
                                        c.patientID AS 'patient_id',
                                      'calcium' AS 'med_name',
                                      c.calSchedTablets AS 'tab',
                                      c.calSchedDate AS 'sched_date',
                                      c.calSchedStatus AS 'status'
                                      FROM calcium_sched c
                                      UNION ALL
                                      SELECT 
                                        d.patientID AS 'patient_id',
                                      'deworming' AS 'med_name',
                                      d.dwSchedTablet AS 'tab',
                                      d.dwSchedDate AS 'sched_date',
                                      d.dwSchedStatus AS 'status'
                                      FROM deworming_sched d
                                      UNION ALL
                                      SELECT 
                                        i.patientID AS 'patient_id',
                                      'iodine' AS 'med_name',
                                      i.iodSchedTablet AS 'tab',
                                      i.iodSchedDate AS 'sched_date',
                                      i.iodSchedStatus AS 'status'
                                      FROM iodine_sched i
                                      UNION ALL
                                      SELECT
                                        m.patientID AS 'patient_id',
                                      'iron' AS 'med_name',
                                      m.ironSchedTablets AS 'tab',
                                      m.ironSchedDate AS 'sched_date',
                                      m.ironSchedStatus AS 'status'
                                      FROM micronutrient_sched m
                                    ) tmp
                                    LEFT JOIN patient p
                                    ON p.patientID = tmp.patient_id
                                    LEFT JOIN barangay b
                                    ON b.barangayID = p.barangayID
                                    LEFT JOIN station s
                                    ON s.stationID = b.stationID
                                    WHERE 
                                    tmp.sched_date BETWEEN '$startDate' AND '$endDate'
                                    AND tmp.status = 'Pending'
                                    GROUP BY tmp.med_name, b.barangayID
                                    ";
                $projectionResult = mysqli_query($conn, $projectionQuery);

                while ($res = mysqli_fetch_object($projectionResult)):
                  $bhsInventoryQuery = "SELECT 
                                        i.inventoryID,
                                        s.stationID,
                                        m.medicineID,
                                        m.medicineName,
                                        m.medicineCategory,
                                        s.stationName,
                                        i.availableStock as 'bhs_stocks',
                                        m.medicineStock as 'rhu_stocks'
                                      FROM inventory i
                                      LEFT JOIN station s
                                      ON s.stationID = i.stationID
                                      LEFT JOIN medicine m
                                      ON m.medicineID = i.medicineID
                                      WHERE
                                      isActive = 1
                                      AND s.stationID = $res->stationID
                                      AND m.medicineName = '$res->med_name'";

                  $bhsInventoryResult = mysqli_query($conn, $bhsInventoryQuery);
                  $bhsInventoryResult = mysqli_fetch_object($bhsInventoryResult);

                  $categoryNames = [
                    "iron" => "Iron Sulfate",
                    "calcium" => "Calcium Carbonate",
                    "iodine" => "Iodine Capsule",
                    "deworming" => "Deworming"
                  ];

                  $toAdd = $bhsInventoryResult->bhs_stocks < $res->needed ? $res->needed - $bhsInventoryResult->bhs_stocks : 0;

                ?>
                  <tr>
                    <td><?= $bhsInventoryResult->stationName ?></td>
                    <td><?= $bhsInventoryResult->medicineName ?></td>
                    <td><?= $categoryNames[$bhsInventoryResult->medicineCategory] ?></td>
                    <td><?= $bhsInventoryResult->bhs_stocks ?></td>
                    <td><?= $res->needed ?></td>
                    <td><?= $toAdd ?></td>
                    <td><?= $bhsInventoryResult->rhu_stocks ?></td>
                    <td><?= "$formattedDatePeriodStart - $formattedDatePeriodEnd" ?></td>
                    <td>
                      <button class="btn btn-primary btn-sm" onclick="showModal(<?= $bhsInventoryResult->inventoryID ?>, '<?= $bhsInventoryResult->medicineName ?>', '<?= $categoryNames[$bhsInventoryResult->medicineCategory] ?>', '<?= $bhsInventoryResult->rhu_stocks ?>')" <?= $toAdd == 0 ? "disabled" : "" ?>>
                        Add Medicine
                      </button>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Add Medicine
        </h5>
        <small class="badge bg-primary mx-2">
          Available stocks <span id="stocksAvailable"></span>
        </small>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="rhu-functions.php" method="POST">
        <div class="modal-body">
          <input type="hidden" name="inventory_id" id="inventoryID">
          <div class="row align-items-center my-2">
            <div class="col-xl-3 col-lg-3 col-md-3">
              <label for="medicineName" class="form-label">Medicine Name:</label>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9">
              <input type="text" class="form-control" id="medicineName" name="medicineName" readonly required>
            </div>
          </div>
          <div class="row align-items-center my-2">
            <div class="col-xl-3 col-lg-3 col-md-3">
              <label for="medicineCategory" class="form-label">Medicine Category:</label>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9">
              <input type="text" class="form-control" id="medicineCategory" name="medicineCategory" readonly required>

            </div>
          </div>
          <div class="row align-items-center my-2">
            <div class="col-xl-3 col-lg-3 col-md-3">
              <label for="toAdd" class="form-label">To Add:</label>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9">
              <input type="number" class="form-control" id="toAdd" name="toAdd" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="updateBhsMed">Save</button>
        </div>
    </div>
    </form>

  </div>
</div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
<script>
  function showModal(inventoryID, medicineName, medicineCategory, availableStock) {
    $("#stocksAvailable").text(availableStock)
    $("#inventoryID").val(inventoryID)
    $("#medicineName").val(medicineName)
    $("#medicineCategory").val(medicineCategory)

    $("#toAdd").attr("max", availableStock)

    $("#addMedicineModal").modal("show");
  }

  $("#table-patient-records").DataTable({
    paging: true,
    lengthChange: true,
    autoWidth: false,
    responsive: true,
    ordering: false,
    searching: true
  })
</script>