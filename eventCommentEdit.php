<?php
    include_once "header.php";
    include_once "api/api_functions.php";

    if (isset($_POST["CommentID"])) {
        displayEventCommentEditing($_POST["EventID"], $_POST["UserID"], $_POST["CommentID"]);
    }
