<?php
    include_once 'functions.php';
    include_once 'signup_error_checking_functions.php';

    // Check if the user got to this "page" in the correct way
    if (!isset($_POST["submit"])) {
        // Only here if they didn't get here through the submit button
        // so return them to the signup page
        header("location: ../signup.php");
        exit(); // Stop this program from running
    }

    // Here if the user got here the correct way
    // Process the user information
    $UniversityID = $_POST["UniversityID"];
    $Name = $_POST["Name"];
    $Gmail = $_POST["Gmail"];
    $Phone = $_POST["Phone"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];

    if (signupInputIsEmpty($UniversityID, $Name, $Password, $ConfirmPassword, $Gmail)) {
        header("location: ../signup.php?error=signupInputIsEmpty");
        exit();
    } else if (usernameIsInvalid($Name)) {
        header("location: ../signup.php?error=usernameIsInvalid");
        exit();
    } else if (passwordIsTooSimple($Password)) {
        header("location: ../signup.php?error=passwordIsTooSimple");
        exit();
    } else if (passwordsDoNotMatch($Password, $ConfirmPassword)) {
        header("location: ../signup.php?error=passwordsDoNotMatch");
        exit();
    } else if (usernameExists($Name, $Gmail)) {
        header("location: ../signup.php?error=usernameExists");
        exit();
    } else if (emailIsInvalid($Gmail)) {
        header("location: ../signup.php?error=emailIsInvalid");
        exit();
    }

    // Insert the new user into the database
    signup($UniversityID, $Name, $Gmail, $Phone, $Password);
    exit(); // End this script
