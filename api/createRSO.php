<?php

include_once 'api_functions.php';

session_start();
$OwnerID = $_SESSION["ID"];
$UniversityID = getUserUniversity($OwnerID);

$MemberInfo_1 = usernameExists($_POST["M1"], $_POST["M1"]);
$MemberInfo_2 = usernameExists($_POST["M2"], $_POST["M2"]);
$MemberInfo_3 = usernameExists($_POST["M3"], $_POST["M3"]);
$MemberInfo_4 = usernameExists($_POST["M4"], $_POST["M4"]);


if($MemberInfo_1["UniversityID"] != $UniversityID || 
    $MemberInfo_2["UniversityID"] != $UniversityID || 
    $MemberInfo_3["UniversityID"] != $UniversityID || 
    $MemberInfo_4["UniversityID"] != $UniversityID) 
    header("location: ../index?error=universitiesDoNotMatch");

$MemberID_1 = $MemberInfo_1["ID"];
$MemberID_2 = $MemberInfo_2["ID"];
$MemberID_3 = $MemberInfo_3["ID"];
$MemberID_4 = $MemberInfo_4["ID"];

createRSO($UniversityID, $OwnerID, $Name, $MemberID_1, $MemberID_2, $MemberID_3, $MemberID_4);


header("location: ../index");

/*
*/