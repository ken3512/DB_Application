<?php
    include_once "api_functions.php";

    if (isset($_POST["CommentID"])) {
        updateEventComment($_POST["CommentID"], $_POST["NewComment"]);
        header("location: ../events");
    }
