<?php
session_start();
include('includes/header.php');
include 'database/dbconfig.php';

if (isset($_SESSION['patient'])) {
  unset($_SESSION['patient']);
}
?>

<div class="container d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow w-50">
    <div class="card-body">
      <div class="text-center">
        <h3 class="mb-4">Maternal Health <br>Information Systems for RHU</h3>
      </div>
      <form action="user-functions.php" method="POST">
        <div class="form-floating my-3">
          <input type="text" name="patientSerialNumber" id="familySerialNumber" class="form-control" placeholder="">
          <label for="familySerialNumber">Family Serial Number</label>
        </div>
        <div class="form-floating my-3">
          <input type="text" name="patientLastName" id="lastName" class="form-control" placeholder="">
          <label for="lastName">Last Name</label>
        </div>
        <button type="submit" name="search" class="btn btn-primary w-100">Search</button>
      </form>
    </div>
  </div>
</div>

<?php
include('includes/scripts.php');
?>