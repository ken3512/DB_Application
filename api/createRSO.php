<?php

include_once 'api_functions.php';

session_start();
$OwnerID = $_SESSION["ID"];
$UniversityID = getUserUniversity($OwnerID);

$Name = $_POST["Name"];
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

<form action="api/createRSO.php" method="POST">
        <input type="text" name="Name" placeholder="RSON Name">
        <br>
        <input type="text" name="M1" placeholder="Member 1">
        <br>
        <input type="text" name="M2" placeholder="Member 2">
        <br>
        <input type="text" name="M3" placeholder="Member 3">
        <br>
        <input type="text" name="M4" placeholder="Member 4">
        <br>
        <button type="submit" name="submit">Register RSO</button>
    </form>
<?php 

*/