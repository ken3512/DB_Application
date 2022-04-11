<?php
    include_once "api_functions.php";
    
    session_start();
    $EventName = $_POST["EventName"];
    $EventDescription = $_POST["EventDescription"];
    $EventCategory = $_POST["EventCategory"];
    $EventPrivacy = $_POST["EventPrivacy"];
    $ContactPhone = $_POST["ContactPhone"];
    $ContactEmail = $_POST["ContactEmail"];
    $EventLocation = $_POST["EventLocation"];
    
    // Get the phone and email of the user that is logged in 
    // and populate it the variables if they aren't set
    $userData = getUserInfoById($_SESSION["ID"]);
    if (empty($ContactEmail)){
        $ContactEmail = $userData["Gmail"];
    }
    if (empty($ContactPhone)){
        $ContactPhone = $userData["Phone"];
    }
    
    createEvent($EventName, $EventDescription, $EventCategory, $EventPrivacy, $ContactPhone, $ContactEmail, $EventLocation, $_SESSION["ID"]);
    