<?php
session_start();
if (!isset($_SESSION['user_authenticated']) || $_SESSION['userType'] !== "BHS") {
  header('Location: index.php');
  exit();
}
include('includes/header.php');
include('includes/midwife_navbar.php');
?>
<style>
  h5 {
    text-transform: uppercase;
    font-size: 20px !important;
    font-weight: 400 !important;
    letter-spacing: 1px !important;
  }

  .container {
    height: 70vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  a.card {
    text-decoration: none;
    min-height: 20vh !important;
  }

  .card a {
    text-decoration: none;
    color: inherit;
  }
</style>
<div class="container justify-content-center align-items-center">
  <div class="row w-100">
    <div class="col-md-12 text-center mb-3 text-dark d-flex justify-content-center align-items-center">
      <h5>Select Schedule Type</h5>
    </div>
    <div class="col-md-4 mb-3">
      <a href="bhs_prenatal-schedule" class="card shadow text-center index-card py-3 text-primary">
        <div class="card-body d-flex justify-content-center align-items-center">
          <h5>Pre-Natal</h5>
        </div>
      </a>
    </div>
    <div class="col-md-4 mb-3">
      <a href="bhs_deworming-schedule" class="card shadow text-center index-card py-3 text-primary">
        <div class="card-body d-flex justify-content-center align-items-center">
          <h5>Deworming</h5>
        </div>
      </a>
    </div>
    <div class="col-md-4 mb-3">
      <a href="bhs_tetanus-schedule" class="card shadow text-center index-card py-3 text-primary">
        <div class="card-body d-flex justify-content-center align-items-center">
          <h5>Tetanus</h5>
        </div>
      </a>
    </div>
  </div>
</div>

<?php
include 'includes/scripts.php';
?>