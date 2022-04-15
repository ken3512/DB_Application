<?php
    include_once "api_functions.php";
    
    session_start();


    $long = $_POST["Long"];
    $lat = $_POST["Lat"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    
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
    if (empty($ContactEmail)){
        $ContactEmail = $userData["Gmail"];
    }
    if (empty($ContactPhone)){
        $ContactPhone = $userData["Phone"];
    }
    
    createEvent($EventName, $EventDescription, $EventCategory, $EventPrivacy, $ContactPhone, $ContactEmail, $EventLocationName, $EventLocationDescription, $_SESSION["ID"], $RSOID, $long, $lat, $start, $end);
    