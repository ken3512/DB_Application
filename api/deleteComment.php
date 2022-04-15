<?php
    include_once "api_functions.php";
    
    if (isset($_POST["CommentID"])) {
        // echo $_POST["commentID"];
        deleteComment($_POST["CommentID"]);
    }
