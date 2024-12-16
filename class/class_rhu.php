<?php
    require './database/dbconfig.php';

    if (!class_exists('RHU')) {
        class RHU {
            // STATION CRUD
            public function addStation($stationName){
                global $conn;

                $query = "SELECT * FROM station WHERE stationName = '$stationName'";
                $result = mysqli_query($conn, $query);

                if($result->num_rows > 0){
                    echo "<script>alert('Station name already exists.');window.location.href='./rhu_midwife-profiles';</script>";
                } else{
                    $query = "INSERT INTO station(stationName) VALUES('$stationName')";
                    $result = mysqli_query($conn, $query);

                    if ($result){
                        return true;
                    } else{
                        return false;
                    }
                }
            }

            public function modifyStation($stationID, $stationName, $stationStatus){
                global $conn;

                $query = "UPDATE station 
                          SET stationName = '$stationName', isActive = '$stationStatus'
                          WHERE stationID = '$stationID'";
                $result = mysqli_query($conn, $query);

                if ($result){
                    return true;
                } else{
                    return false;
                }
            }

            public function addBarangay($stationID, $barangayName){
                global $conn;

                $query = "SELECT * FROM barangay WHERE barangayName = '$barangayName' AND stationID = '$stationID'";
                $result = mysqli_query($conn, $query);

                if($result->num_rows > 0){
                    echo "<script>alert('Barangay name already exists.');window.location.href='./rhu_midwife-profiles';</script>";
                } else{
                    $query = "INSERT INTO barangay(stationID, barangayName) VALUES('$stationID', '$barangayName')";
                    $result = mysqli_query($conn, $query);

                    if ($result){
                        return true;
                    } else{
                        return false;
                    }
                }
            }

            public function modifyBarangay($stationID, $barangayID, $barangayName, $barangayStatus){
                global $conn;

                $query = "UPDATE barangay 
                          SET stationID = '$stationID', barangayName = '$barangayName', isActive = '$barangayStatus'
                          WHERE barangayID = '$barangayID'";
                $result = mysqli_query($conn, $query);

                if ($result){
                    return true;
                } else{
                    return false;
                }
            }

            public function addBHS($bhsFname, $bhsLname, $bhsContactNumber, $bhsStation, $bhsUname, $bhsPassword){
                global $conn;

                $query = "INSERT INTO user(stationID, userFname, userLname, userUname, userPassword, userContactNumber, userType)
                          VALUES('$bhsStation', '$bhsFname', '$bhsLname', '$bhsUname', '$bhsPassword', '$bhsContactNumber', 'BHS')";
                $result = mysqli_query($conn, $query);

                if($result){
                    return true;
                } else {
                    return false;
                }
            }

            public function modifyBHS($bhsID, $bhsFname, $bhsLname, $bhsContactNumber, $bhsStation, $bhsUsername, $bhsPassword){
                global $conn;

                $query = "UPDATE user
                          SET userFname = '$bhsFname', userLname = '$bhsLname', userContactNumber = '$bhsContactNumber', stationID = '$bhsStation', userUname = '$bhsUsername', userPassword = '$bhsPassword'
                          WHERE userID = '$bhsID'";
                $result = mysqli_query($conn, $query);

                if ($result){
                    return true;
                } else {
                    return false;
                }
            }

            public function addMedicine($medicineName, $medicineCategory, $medicineStock){
                global $conn;

                $query = "INSERT INTO medicine(medicineName, medicineCategory, medicineStock, dateUpdate)
                          VALUES('$medicineName', '$medicineCategory', '$medicineStock', CURDATE())";
                $result = mysqli_query($conn, $query);

                if ($result){
                    return true;
                } else {
                    return false;
                }
            }

            public function modifyMedicine($medicineID, $medicineName, $medicineCategory, $medicineStock){
                global $conn;

                $query = "UPDATE medicine
                          SET medicineName = '$medicineName', medicineCategory = '$medicineCategory', medicineStock = '$medicineStock', dateUpdate = CURDATE()
                          WHERE medicineID = '$medicineID'";
                $result = mysqli_query($conn, $query);

                if ($result){
                    return true;
                } else {
                    return false;
                }
            }

            public function addInventory($stationID, $medicineID, $availableStock) {
                global $conn;
            
                $query = "SELECT medicineStock FROM medicine WHERE medicineID = $medicineID";
                $result = mysqli_query($conn, $query);
                
                $medicineRow = mysqli_fetch_assoc($result);
            
                if ($medicineRow && $medicineRow['medicineStock'] >= $availableStock) {
                    $query = "INSERT INTO inventory(stationID, medicineID, availableStock, dateUpdate)
                              VALUES('$stationID', '$medicineID', '$availableStock', CURDATE())";
                    $insertResult = mysqli_query($conn, $query);
            
                    if ($insertResult) {
                        $newStock = $medicineRow['medicineStock'] - $availableStock;
                        $updateStockQuery = "UPDATE medicine
                                             SET medicineStock = '$newStock'
                                             WHERE medicineID = '$medicineID'";
                        $updateStockResult = mysqli_query($conn, $updateStockQuery);
            
                        if ($updateStockResult) {
                            return true; 
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    echo "<script>alert('There is no available stock for this medicine.');window.location.href='./rhu_inventory';</script>";
                    return false; 
                }
            }

            public function modifyInventory($inventoryID, $newAvailableStock) {
                global $conn;
            
                $query = "SELECT availableStock, medicineID FROM inventory WHERE inventoryID = '$inventoryID'";
                $result = mysqli_query($conn, $query);
            
                if ($result && mysqli_num_rows($result) > 0) {
                    $inventoryRow = mysqli_fetch_assoc($result);
                    $currentAvailableStock = $inventoryRow['availableStock'];
                    $medicineID = $inventoryRow['medicineID'];
            
                    $updateQuery = "UPDATE inventory
                                    SET availableStock = '$newAvailableStock'
                                    WHERE inventoryID = '$inventoryID'";
                    $updateResult = mysqli_query($conn, $updateQuery);
            
                    if ($updateResult) {
                        $stockDifference = $newAvailableStock - $currentAvailableStock;
            
                        $updateStockQuery = "UPDATE medicine
                                             SET medicineStock = medicineStock - '$stockDifference'
                                             WHERE medicineID = '$medicineID'";
                        mysqli_query($conn, $updateStockQuery);
            
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_inventory';</script>";
                    return false; 
                }
            }
            
        }
    }
?>