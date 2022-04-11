<?php

include_once 'api_functions.php';

session_start();
$MemberID = $_SESSION["ID"];
$RSOID = $_POST["RSOID"];

registerMember($RSOID, $MemberID);

header("location: ../joinRSO");