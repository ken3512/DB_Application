<?php
    include_once "api_functions.php";
    
    if (isset($_POST["CommentID"])) {
        echo $_POST["CommentID"] . '<br>';
        deleteEventComment($_POST["CommentID"]);
    }