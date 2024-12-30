<?php
require './database/dbconfig.php';

if (!class_exists('User')) {
  class User
  {
    // login
    public function login($username, $password)
    {
      global $conn;

      $query = "SELECT * FROM user WHERE userUname = '$username' AND userPassword = '$password' AND isActive = 1";
      $result = mysqli_query($conn, $query);

      if ($row = mysqli_fetch_assoc($result)) {
        $userType = $row['userType'];
        return $userType;
      } else {
        return false;
      }
    }

    // patient search
    public function search($serialNumber, $lastName)
    {
      global  $conn;

      $query = "SELECT * FROM patient 
                          WHERE patientSerialNumber = '$serialNumber' AND
                          patientLname = '$lastName' AND
                          isActive = 1";
      $result = mysqli_query($conn, $query);

      if ($row = mysqli_fetch_assoc($result)) {
        $patientID = $row['patientID'];
        return $patientID;
      } else {
        return false;
      }
    }
  }
}
