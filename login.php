<?php
session_start();
include('includes/header.php');
include 'database/dbconfig.php';
?>
<script type = "text/javascript">
    function preventBack(){window.history.forward()};
    setTimeout("preventBack()", 0);
    window.onunload=function(){null;}
</script>
<style>
   #wrapper {
      background-image: url('img/bg.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      width: 100%;
      height: 100vh;
   }
</style>

<div class="container d-flex align-items-center justify-content-center vh-100">
   <div class="card w-50">
      <div class="card-body">
         <?php if (isset($_SESSION['error'])): ?>
            <p class="text-center text-danger"><i class="fa-solid fa-circle-exclamation"></i> Login error details</p>
            <?php $error_class = 'is-invalid'; ?>
            <?php unset($_SESSION['error']); ?>
         <?php else: ?>
            <?php $error_class = ''; ?>
         <?php endif; ?>

         <div class="text-center">
            <h1 class="h2 text-black-900 font-weight-bold mb-4">Login</h1>
         </div>
         
         <form class="user" action="user-functions.php" method="POST">
            <div class="form-floating my-3">
               <input type="text" name="username" id="username" class="form-control <?php echo $error_class; ?>" placeholder="Enter username">
               <label for="username">Username</label>
            </div>
            <div class="form-floating my-3">
               <input type="password" name="password" id="password" class="form-control <?php echo $error_class; ?>" placeholder="Enter password">
               <label for="password">Password</label>
            </div>
            <button type="submit" name="login" class="btn btn-primary my-3 w-100">Login</button>
         </form>
      </div>
   </div>
</div>

<script>
   document.querySelectorAll('#username, #password').forEach(input => {
      input.addEventListener('input', () => {
         document.getElementById('username').classList.remove('is-invalid');
         document.getElementById('password').classList.remove('is-invalid');
      });
   });
</script>


<?php
include('includes/scripts.php');
?>
