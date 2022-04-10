<?php

include_once 'api_functions.php';

session_start();
$UserID = $_SESSION["ID"];
$EventID = $_POST["EventID"];
$Comment = $_POST['Comment'];

comment($EventID, $UserID, $Comment);

header("location: ../events");

/*
    <form action="api/Comment.php" method="POST">
        <input type="hidden" name="EventID" value=7>
        <input type="text" name="Comment" placeholder="Text">
        <br>
        <button type="submit" name="submit">Comment</button>
    </form>
*/
    