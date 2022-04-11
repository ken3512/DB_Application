<?php
    include_once 'api_functions.php';
    session_start();
    // Check if we got here through the submit button
    // on the login form
    if (isset($_POST["submit"])) {
        if (!empty($_POST["UsernameChange"])) {
            changeUsername($_SESSION["ID"], $_POST["UsernameChange"]);
        }
        if (isset($_POST["WebsiteAppearanceValue"])) {
            setUserWebsiteAppearance($_SESSION["ID"], $_POST["WebsiteAppearanceValue"]);
        }
        header("location: ../settings");
    }
    else {
        // We didn't get here through submitting a login request so
        // go back to the login page
        header("location: ../index.php");
        exit();
    }
