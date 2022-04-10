<?php
    include_once 'api_functions.php';
    include_once 'helper_functions.php';

    // Check if we got here through the submit button
    // on the login form
    if (isset($_POST["submit"])) {

        // Get the information that was posted
        $Gmail = $_POST["Gmail"];
        $Password = $_POST["Password"];

        if (loginInputIsEmpty($Gmail, $Password)) {
            header("location: ../login.php?error=loginInputIsEmpty");
            exit();
        } 
        
        login($Gmail, $Password);
    }
    else {
        // We didn't get here through submitting a login request so
        // go back to the login page
        header("location: ../login.php");
        exit();
    }

