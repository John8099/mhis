<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: index");
  exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mhis";

$conn = mysqli_connect($host, $user, $pass, $dbname);
