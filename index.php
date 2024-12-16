<?php
   session_start();

   if (!isset($_SESSION['user_authenticated'])){
      header('Location: patient');
      exit();
   }

   $userType = $_SESSION['userType'];
   if ($userType === 'RHU'){
      header("Location: ./rhu_dashboard");
      exit();
   } elseif ($userType === 'BHS'){
      header("Location: ./bhs_dashboard");
      exit();
   } 
?>