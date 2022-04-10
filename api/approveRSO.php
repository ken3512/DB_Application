<?php

include_once 'api_functions.php';

$UserID = 1;
$RSOID = 3;

approveRSO($UserID, $RSOID);

header("location: ../index");


/*
    <form action="api/approveRSO.php" method="POST">
        <input type="submit" name="submit" value="RSOID">Approve</input>
    </form>
*/