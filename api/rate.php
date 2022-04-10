<?php

include_once 'api_functions.php';

$EventID = 1;
$UserID = 2;
$Rating = $_POST['rating'];

rate($EventID, $UserID, $Rating);

header("location: ../index");

/*
    <form action="api/rate.php" method="POST">
        <input type="radio" name="rating" value=1>
        <input type="radio" name="rating" value=2>
        <input type="radio" name="rating" value=3>
        <input type="radio" name="rating" value=4>
        <input type="radio" name="rating" value=5>
        <p>&ensp;1&emsp;2&emsp;3&emsp;4&emsp;5<p>
        <button type="submit" name="submit">Rate</button>
    </form>
*/
    