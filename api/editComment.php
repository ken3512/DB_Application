<?php
    include_once "api_functions.php";

    if (isset($_POST["CommentID"])) {
        updateComment($_POST["CommentID"], $_POST["NewComment"]);
        header("location: ../index.php");
    }
