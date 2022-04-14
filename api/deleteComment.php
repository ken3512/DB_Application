<?php
    include_once "api_functions.php";
    
    if (isset($_POST["commentID"])) {
        // echo $_POST["commentID"];
        deleteComment($_POST["commentID"]);
    }
