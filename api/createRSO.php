<?php

include_once 'api_functions.php';


$OwnerID = 6;
$UniversityID = getUserUniversity($OwnerID);
$Name = $_POST["Name"];
$MemberID_1 = $_POST["M1"];
$MemberID_2 = $_POST["M2"];
$MemberID_3 = $_POST["M3"];
$MemberID_4 = $_POST["M4"];

createRSO($UniversityID, $OwnerID, $Name, $MemberID_1, $MemberID_2, $MemberID_3, $MemberID_4);


header("location: ../index");

/*
*/