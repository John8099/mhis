<style>
  .img-profile {
    height: 60px;
    width: 60px;
  }

  #content-wrapper {
    background-size: cover; 
  }

  .navbar-nav.sidebar.sidebar-dark.accordion{
    background-color: #095b94;
  }

  #print-button {
    background-color: white;
    color: #007bff;
    border: none;
    cursor: pointer;
    position: relative;
  }

  .collapse-item:hover {
    background-color: #095b94 !important; 
    color: white !important; 
  }

  @media print {
    .navbar-nav {
      display: none;
    }
    .sticky-footer {
      display: none;
    }
    .card-header {
      display: none;
    }
    .input-group {
      display: none;
    }
    * { 
      overflow: hidden; 
    }
    @page {
      size: auto; 
      margin: 10mm; 
      landscape: portrait; 
    }
  }  
</style>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="bhs_dashboard">
    <div class="sidebar-brand-icon rotate-n-15">
      <img class="img-profile rounded-circle" src="img/pregnant.jpg">
    </div>
  </a>
  <h6 class="text-white text-center">Maternal Health <br>Information Systems for RHU</h6>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_dashboard.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_dashboard">
      <i class="fa fa-home"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_scheduled-patients.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_scheduled-patients">
      <i class="fa-solid fa-calendar-days"></i>
      <span>Calendar</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_patient-registration.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_patient-registration" aria-expanded="true">
      <i class="fa-solid fa-pen-to-square"></i>   
      <span>Add Patient Data</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_patient-records.php' || basename($_SERVER['PHP_SELF']) == 'bhs_patient-edit.php' || 
                                  basename($_SERVER['PHP_SELF']) == 'bhs_patient-view.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_patient-records" aria-expanded="true">
      <i class="fa-solid fa-folder-open"></i>
      <span>Patient Records</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_select-patient.php' || 
                                  basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-services.php' || 
                                  basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-other-services.php' ||
                                  basename($_SERVER['PHP_SELF']) == 'bhs_prenatal-schedule.php' || 
                                  basename($_SERVER['PHP_SELF']) == 'bhs_deworming-schedule.php' ||
                                  basename($_SERVER['PHP_SELF']) == 'bhs_tetanus-schedule.php' ||
                                  basename($_SERVER['PHP_SELF']) == 'bhs_calcium-schedule.php' ||
                                  basename($_SERVER['PHP_SELF']) == 'bhs_iron-schedule.php' ||
                                  basename($_SERVER['PHP_SELF']) == 'bhs_iodine-schedule.php')? 'active' : ''; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseScheduling" aria-expanded="<?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_select-patient.php' || basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-services.php') ? 'true' : 'false'; ?>" aria-controls="collapseScheduling">
      <i class="fa-regular fa-calendar-check"></i>
      <span>Book Schedule</span>
    </a>
    <hr class="sidebar-divider my-0">
    <div id="collapseScheduling" class="collapse <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_select-patient.php' || 
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-services.php' || 
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-other-services.php' || 
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_prenatal-schedule.php' || 
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_deworming-schedule.php' ||
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_tetanus-schedule.php' ||
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_calcium-schedule.php' ||
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_iron-schedule.php' ||
                                                             basename($_SERVER['PHP_SELF']) == 'bhs_iodine-schedule.php') ? 'show' : ''; ?>" aria-labelledby="headingScheduling" data-parent="#accordionSidebar">
        <div class="py-2 collapse-inner rounded">
          <a class="collapse-item text-white <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-services.php' || basename($_SERVER['PHP_SELF']) == 'bhs_prenatal-schedule.php' || basename($_SERVER['PHP_SELF']) == 'bhs_deworming-schedule.php' || basename($_SERVER['PHP_SELF']) == 'bhs_tetanus-schedule.php') ? 'active' : 'inactive'; ?>" href="bhs_select-schedule-services"><i class="fa-solid fa-hand-holding-medical"></i> <span> Services</span></a>
          <hr class="sidebar-divider my-0">
          <a class="collapse-item text-white text-wrap <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_select-schedule-other-services.php' || basename($_SERVER['PHP_SELF']) == 'bhs_calcium-schedule.php' || basename($_SERVER['PHP_SELF']) == 'bhs_iron-schedule.php' || basename($_SERVER['PHP_SELF']) == 'bhs_iodine-schedule.php') ? 'active' : 'inactive'; ?>" href="bhs_select-schedule-other-services"><i class="fa-solid fa-pills"></i> <span> Micronutrient Supplementation</span></a>
        </div>
    </div>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_classification.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_classification" aria-expanded="true">
      <i class="fa-solid fa-chart-column"></i>
      <span>Classification</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_prediction.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_prediction" aria-expanded="true">
      <i class="fa-solid fa-chart-line"></i>
      <span>Prediction</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bhs_inventory.php') ? 'active' : 'inactive'; ?>">
    <a class="nav-link collapsed" href="bhs_inventory" aria-expanded="true">
    <i class="fa-solid fa-warehouse"></i>
      <span>Inventory</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0">
  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>

<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow d-sm-none">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                  aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
              <h3 class="h6 mb-0 text-gray-800"> Welcome, Midwife <?php echo $_SESSION['user']; ?>!</h3>
            </span>
            <img class="img-profile rounded-circle" style="height: 60px; width: 60px;" src="img/midwife.png">
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <form action="logout.php" method="POST">
              <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>