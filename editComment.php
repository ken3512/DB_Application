<?php
    include_once "header.php";
    
    if (isset($_POST["commentID"])) {
        displayEditingComment($_POST["commentID"]);
    }
