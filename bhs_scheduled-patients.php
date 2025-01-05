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

$stationID = "";

if ($result && mysqli_num_rows($result) > 0) {
  $user_data = mysqli_fetch_assoc($result);
  $stationID = $user_data['stationID'];
}
$schedules = [];

$scheduleQueries = [
  "SELECT 
    ts.ttSchedID AS scheduleID, 
    ts.ttSchedDate AS scheduleDate, 
    'Tetanus' AS scheduleType, 
    p.patientID, CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName, 
    ts.ttSchedStatus AS scheduleStatus 
  FROM tetanus_sched ts 
  LEFT JOIN patient p 
  ON ts.patientID = p.patientID 
  WHERE p.barangayID IN (SELECT barangayID FROM barangay WHERE stationID = $stationID)",

  "SELECT 
    cs.calSchedID AS scheduleID, 
    cs.calSchedDate AS scheduleDate, 
    'Calcium' AS scheduleType, 
    p.patientID, CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName, 
    cs.calSchedStatus AS scheduleStatus 
  FROM calcium_sched cs 
  LEFT JOIN patient p 
  ON cs.patientID = p.patientID 
  WHERE p.barangayID IN (SELECT barangayID FROM barangay WHERE stationID = $stationID)",

  "SELECT 
    ds.dwSchedID AS scheduleID, 
    ds.dwSchedDate AS scheduleDate, 
    'Deworming' AS scheduleType, 
    p.patientID, CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName, 
    ds.dwSchedStatus AS scheduleStatus 
  FROM deworming_sched ds 
  LEFT JOIN patient p 
  ON ds.patientID = p.patientID 
  WHERE p.barangayID IN (SELECT barangayID FROM barangay WHERE stationID = $stationID)",

  "SELECT 
    ms.ironSchedID AS scheduleID, 
    ms.ironSchedDate AS scheduleDate, 
    'Micronutrient' AS scheduleType, 
    p.patientID, CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName, 
    ms.ironSchedStatus AS scheduleStatus 
  FROM micronutrient_sched ms 
  LEFT JOIN patient p 
  ON ms.patientID = p.patientID 
  WHERE p.barangayID IN (SELECT barangayID FROM barangay WHERE stationID = $stationID)",

  "SELECT 
    ps.pnSchedID AS scheduleID, 
    ps.pnSchedCheckupDate AS scheduleDate, 
    'Pre-natal' AS scheduleType, 
    p.patientID, CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName, 
    ps.pnSchedStatus AS scheduleStatus 
  FROM `pre-natal_sched` ps LEFT JOIN patient p 
  ON ps.patientID = p.patientID 
  WHERE p.barangayID IN (SELECT barangayID FROM barangay WHERE stationID = $stationID)",

  "SELECT 
    iod.iodSchedID  AS scheduleID, 
    iod.iodSchedDate AS scheduleDate, 
    'Iodine' AS scheduleType, 
    p.patientID, CONCAT(p.patientFName, ' ', p.patientMname, ' ', p.patientLname) AS patientName, 
    iod.iodSchedStatus AS scheduleStatus 
  FROM `iodine_sched` iod LEFT JOIN patient p 
  ON iod.patientID = p.patientID 
  WHERE p.barangayID IN (SELECT barangayID FROM barangay WHERE stationID = $stationID)"
];

foreach ($scheduleQueries as $query) {
  $result = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $schedules[] = [
      'date' => $row['scheduleDate'],
      'type' => $row['scheduleType'],
      'patient' => $row['patientName'],
      'patientID' => $row['patientID'],
      'scheduleID' => $row['scheduleID'],
      'scheduleStatus' => $row['scheduleStatus']
    ];
  }
}

$calendarEvents = [];
foreach ($schedules as $schedule) {
  $color = '';
  switch ($schedule['type']) {
    case 'Tetanus':
      $color = 'red';
      break;
    case 'Calcium':
      $color = 'blue';
      break;
    case 'Deworming':
      $color = 'green';
      break;
    case 'Micronutrient':
      $color = 'purple';
      break;
    case 'Pre-natal':
      $color = 'orange';
      break;
  }
  $calendarEvents[] = [
    'title' => $schedule['type'] . ' - ' . $schedule['patient'],
    'start' => $schedule['date'],
    'color' => $color,
    'id' => $schedule['patientID'],
    'scheduleID' => $schedule['scheduleID'],
    'patientName' => $schedule['patient'],
    'scheduleType' => $schedule['type'],
    'scheduleDate' => $schedule['date'],
    'scheduleStatus' => $schedule['scheduleStatus']
  ];
}
?>
<style>
  .fc-event {
    cursor: pointer;
  }

  #calendar a {
    text-decoration: none !important;
    color: black;
  }
</style>
<div class="container">
  <div id="calendar"></div>

  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="bhs-functions.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="eventModalLabel">Schedule Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="modalScheduleID" name="modalScheduleID">
            <input type="hidden" name="stationId" value="<?= $stationID ?>">
            <div class="row align-items-center my-2">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <label for="modalPatientName" class="form-label">Patient Name:</label>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <input type="text" name="modalPatientName" class="form-control" id="modalPatientName" readonly required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <label for="modalScheduleType" class="form-label">Schedule Type:</label>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <input type="text" name="modalScheduleType" class="form-control" id="modalScheduleType" readonly required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <label for="modalScheduleDate" class="form-label">Schedule Date:</label>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <input type="date" name="modalScheduleDate" class="form-control" id="modalScheduleDate" required>
              </div>
            </div>
            <div class="row align-items-center my-2">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <label for="modalScheduleStatus" class="form-label">Schedule Status:</label>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <select class="form-select" name="modalScheduleStatus" id="modalScheduleStatus" required>
                  <option value="Pending">Pending</option>
                  <option value="Cancelled">Cancelled</option>
                  <option value="Reschedule">Reschedule</option>
                  <option value="Completed">Completed</option>
                </select>
              </div>
            </div>
            <div class="row align-items-center my-2 d-none" id="divRescheduleDate">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <label for="modalScheduleDate" class="form-label">Reschedule Date:</label>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <input type="date" name="modalRescheduleDate" class="form-control" id="modalRescheduleDate">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="updatePatientSchedule" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/scripts.php'; ?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
  $("#modalScheduleStatus").on("change", function() {
    const value = $(this).val()
    if (value === "Reschedule") {
      $("#divRescheduleDate").removeClass("d-none")
      $("#modalRescheduleDate").prop("required", true)
    } else {
      $("#divRescheduleDate").addClass("d-none")
      $("#modalRescheduleDate").prop("required", false)
      $("#modalRescheduleDate").val("")
    }
  })
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        center: 'dayGridMonth,dayGridWeek'
      },
      initialView: 'dayGridMonth',
      height: 700,
      events: <?php echo json_encode($calendarEvents); ?>,
      eventClick: function(info) {
        console.log(info.event);
        document.getElementById('modalPatientName').value = info.event.extendedProps.patientName;
        document.getElementById('modalScheduleType').value = info.event.extendedProps.scheduleType;
        document.getElementById('modalScheduleDate').value = new Date(info.event.start).toLocaleDateString('en-CA');
        document.getElementById('modalScheduleStatus').value = info.event.extendedProps.scheduleStatus;
        document.getElementById('modalScheduleID').value = info.event.extendedProps.scheduleID;

        if (info.event.extendedProps.scheduleStatus === "Complete") {
          $("button[name='updatePatientSchedule']").hide()
        }

        var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
        eventModal.show();
      }
    });
    calendar.render();
  });
</script>