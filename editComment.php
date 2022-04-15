<?php
    include_once "header.php";
    
    if (isset($_POST["CommentID"])) {
        displayEditingComment($_POST["CommentID"]);
    }
