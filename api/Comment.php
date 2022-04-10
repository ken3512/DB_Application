<?php

include_once 'functions.php';

$EventID = 1;
$UserID = 1;
$Comment = $_POST['Comment'];

comment($EventID, $UserID, $Comment);

header("location: ../index");

/*
    <form action="api/Comment.php" method="POST">
        <input type="text" name="Comment" placeholder="Text">
        <br>
        <button type="submit" name="submit">Comment</button>
    </form>
*/
    