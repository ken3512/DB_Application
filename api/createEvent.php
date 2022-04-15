<?php
    include_once "api_functions.php";
    
    session_start();
    if (isset($_POST["EventName"])) {
        $long = $_POST["Long"];
        $lat = $_POST["Lat"];
        $time = $_POST["time"];
        
        $EventName = $_POST["EventName"];
        $EventDescription = $_POST["EventDescription"];
        $EventCategory = $_POST["EventCategory"];
        $EventPrivacy = $_POST["EventPrivacy"];
        $ContactPhone = $_POST["ContactPhone"];
        $ContactEmail = $_POST["ContactEmail"];
        $EventLocationName = $_POST["EventLocationName"];
        $EventLocationDescription = $_POST["EventLocationDescription"];
        $RSOID = $_POST["RSOs"];
        
        // Get the phone and email of the user that is logged in 
        // and populate it the variables if they aren't set
        $userData = getUserInfoById($_SESSION["ID"]);
        $key = encryptionKey();
        if (empty($ContactEmail)){
            $ContactEmail = decryptthis($userData["Gmail"], $key);
        }
        if (empty($ContactPhone)){
            $ContactPhone = decryptthis($userData["Phone"], $key);
        }
    
        
        createEvent($EventName, $EventDescription, $EventCategory, $EventPrivacy, $ContactPhone, $ContactEmail, $EventLocationName, $EventLocationDescription, $_SESSION["ID"], $RSOID, $long, $lat, $time);
    } else {
        header("location: ../createEvent.php");
    }