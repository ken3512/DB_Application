<?php

include_once 'api_functions.php';

session_start();
$UserID = $_SESSION["ID"];
$RSOID = $_POST["RSOID"];

approveRSO($UserID, $RSOID);

header("location: ../profile");


/*
    <form action="api/approveRSO.php" method="POST">
        <input type="hidden" name="RSOID" value=7>
        <button type="submit" name="submit">Approve</button>
    </form>
*/