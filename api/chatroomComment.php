<?php
    include_once 'api_functions.php';
    session_start();
    
    if (isset($_SESSION["ID"]) || isset($_POST["submit"])) {
        if (empty($_POST["Comment"])) {
            header("location: ../index.php");           
        } else {
            insertChatroomComment($_SESSION["ID"], $_POST["Comment"]);
            // echo $_SESSION["ID"];
            // echo $_POST["Comment"];
            header("location: ../index.php");
        }
    }
    else {
        header("location: ../index.php");
    }
    