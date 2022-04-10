<?php

include_once 'api_functions.php';

session_start();
$UserID = $_SESSION["ID"];
$EventID = $_POST['EventID'];
$Rating = $_POST['rating'];

rate($EventID, $UserID, $Rating);

header("location: ../events");

/*
    <form action="api/rate.php" method="POST">
        <input type="hidden" name="EventID" value=7>
        <input type="radio" name="rating" value=1>
        <input type="radio" name="rating" value=2>
        <input type="radio" name="rating" value=3>
        <input type="radio" name="rating" value=4>
        <input type="radio" name="rating" value=5>
        <p>&ensp;1&emsp;2&emsp;3&emsp;4&emsp;5<p>
        <button type="submit" name="submit">Rate</button>
    </form>
*/
    