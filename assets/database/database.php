<?php
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "dental_sys"; // Replace with your database name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn) {
  echo "";
} else {
  echo "Connection failed: " . mysqli_connect_error();
}
?>