<?php
    require './class/class_rhu.php';
    $classRHU = new RHU;
    session_start();   
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch (true) {
            case isset($_POST['addStation']):
                addStation($classRHU);
                break;
            case isset($_POST['modifyStation']):
                modifyStation($classRHU);
                break;
            case isset($_POST['addBarangay']):
                addBarangay($classRHU);
                break;
            case isset($_POST['modifyBarangay']):
                modifyBarangay($classRHU);
                break;
            case isset($_POST['addBHS']):
                addBHS($classRHU);
                break;
            case isset($_POST['modifyBHS']):
                modifyBHS($classRHU);
                break;
            case isset($_POST['addMedicine']):
                addMedicine($classRHU);
                break;
            case isset($_POST['modifyMedicine']):
                modifyMedicine($classRHU);
                break;
            case isset($_POST['addInventory']):
                addInventory($classRHU);
                break;
            case isset($_POST['modifyInventory']):
                modifyInventory($classRHU);
                break;
            default:
                echo "<script>alert('Invalid action.');window.location.href='index';</script>";
                break;
        }
    }
    
    function addStation($classRHU){
        $stationName = $_POST['stationName'];

        $result = $classRHU->addStation($stationName);

        if($result){
            header("Location: rhu_management");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_management';</script>";
        }
    }

    function modifyStation($classRHU){
        $stationID = $_POST['stationID'];
        $stationName = $_POST['stationName'];
        $stationStatus = $_POST['stationStatus'];

        $result = $classRHU->modifyStation($stationID, $stationName, $stationStatus);

        if($result){
            header("Location: rhu_management");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_management';</script>";
        }
    }

    function addBarangay($classRHU){
        $stationID = $_POST['barangayStation'];
        $barangayName = $_POST['barangayName'];

        $result = $classRHU->addBarangay($stationID, $barangayName);

        if($result){
            header("Location: rhu_management");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_management';</script>";
        }
    }

    function modifyBarangay($classRHU){
        $stationID = $_POST['stationID'];
        $barangayID = $_POST['barangayID'];
        $barangayName = $_POST['barangayName'];
        $barangayStatus = $_POST['barangayStatus'];

        $result = $classRHU->modifyStation($stationID, $barangayID, $barangayName, $barangayStatus);

        if($result){
            header("Location: rhu_management");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_management';</script>";
        }
    }

    function addBHS($classRHU){
        $bhsFname = $_POST['bhsFname'];
        $bhsLname = $_POST['bhsLname'];
        $bhsContactNumber = $_POST['bhsContactNumber$bhsContactNumber'];
        $bhsStation = $_POST['bhsStation'];
        $bhsUname = $_POST['bhsUname'];
        $bhsPassword = $_POST['bhsPassword'];

        $result = $classRHU->addBHS($bhsFname, $bhsLname, $bhsContactNumber, $bhsStation, $bhsUname, $bhsPassword);

        if($result){
            header("Location: rhu_management");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_management';</script>";
        }
    }

    function modifyBHS($classRHU){
        $bhsID = $_POST['bhsID'];
        $bhsFname = $_POST['bhsFname'];
        $bhsLname = $_POST['bhsLname'];
        $bhsContactNumber = $_POST['bhsContactNumber'];
        $bhsStation = $_POST['bhsStation'];
        $bhsUsername = $_POST['bhsUname'];
        $bhsPassword = $_POST['bhsPassword'];

        $result = $classRHU->modifyBHS($bhsID, $bhsFname, $bhsLname, $bhsContactNumber, $bhsStation, $bhsUsername, $bhsPassword);

        if($result){
            header("Location: rhu_management");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_management';</script>";
        }
    }

    function addMedicine($classRHU){
        $medicineName = $_POST['medicineName'];
        $medicineCategory = $_POST['medicineCategory'];
        $medicineStock = $_POST['medicineStock'];

        $result = $classRHU->addMedicine($medicineName, $medicineCategory, $medicineStock);

        if ($result){
            header("Location: rhu_inventory");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_inventory';</script>";
        }
    }

    function modifyMedicine($classRHU){
        $medicineID = $_POST['medicineID'];
        $medicineName = $_POST['medicineName'];
        $medicineCategory = $_POST['medicineCategory'];
        $medicineStock = $_POST['medicineStock'];

        $result = $classRHU->modifyMedicine($medicineID, $medicineName, $medicineCategory, $medicineStock);

        if ($result){
            header("Location: rhu_inventory");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_inventory';</script>";
        }
    }

    function addInventory($classRHU) {
        $stationID = $_POST['stationID'];
        $medicineID = $_POST['medicineID'];
        $availableStock = $_POST['stockDistribution'];

        $result = $classRHU->addInventory($stationID, $medicineID, $availableStock);

        if ($result){
            header("Location: rhu_inventory");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_inventory';</script>";
        }
    }

    function modifyInventory($classRHU) {
        $inventoryID = $_POST['inventoryID'];
        $availableStock = $_POST['stockDistribution'];

        $result = $classRHU->modifyInventory($inventoryID, $availableStock);

        if ($result){
            header("Location: rhu_inventory");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./rhu_inventory';</script>";
        }
    }

    