<?php
    require './class/class_user.php';
    $classUser = new User;
    session_start();   
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch (true) {
            case isset($_POST['login']):
                login($classUser);
                break;
            case isset($_POST['search']):
                search($classUser);
                break;
            default:
                echo "<script>alert('Invalid action.');window.location.href='index';</script>";
                break;
        }
    }
    
    function login($classUser){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $classUser->login($username, $password);

        if($result){
            $_SESSION['user_authenticated'] = true;
            $_SESSION['user'] = $username;
            $_SESSION['userType'] = $result;

            header("Location: index");
        }else{
            $_SESSION['error'] = true;
            header("Location: login");
        }
    }

    function search($classUser){
        $serialNumber = $_POST['patientSerialNumber'];
        $lastName = $_POST['patientLastName'];

        $result = $classUser->search($serialNumber, $lastName);

        if($result){
            $_SESSION['patient']= $result;
            header("Location: view");
        }else{
            echo "<script>alert('An error occurred. Please try again.');window.location.href='./patient';</script>";
        }
    }
