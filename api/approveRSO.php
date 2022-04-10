<?php

include_once 'api_functions.php';

$UserID = 1;
$RSOID = 3;

approveRSO($UserID, $RSOID);

header("location: ../index");


/*
    <form action="api/approveRSO.php" method="POST">
        <button type="submit" name="submit">Approve</button>
    </form>
*/