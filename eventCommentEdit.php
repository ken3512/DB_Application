<?php
    include_once "header.php";
    
    if (isset($_POST["CommentID"])) {
        displayEventCommentEditing($_POST["EventID"], $_POST["UserID"], $_POST["CommentID"]);
    }
