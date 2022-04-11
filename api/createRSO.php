<?php

include_once 'api_functions.php';

session_start();
$OwnerID = $_SESSION["ID"];
$UniversityID = getUserUniversity($OwnerID);

$Name = $_POST["Name"];
$MemberID_1 = $_POST["M1"];
$MemberID_2 = $_POST["M2"];
$MemberID_3 = $_POST["M3"];
$MemberID_4 = $_POST["M4"];

$arr = array($OwnerID, $MemberID_1, $MemberID_2, $MemberID_3, $MemberID_4);

if($MemberID_1 == 0|| 
   $MemberID_2 == 0 || 
   $MemberID_3 == 0 || 
   $MemberID_4 == 0) 
    header("location: ../index?error=notAllSelected");

for ($i = 0; $i < 5; $i++)
  for ($j = $i; $j < 5; $j++)
    if (arr[$i] == arr[$j])
        header("location: ../index?error=sameUserSelected");

$MemberUniv_1 = getUserUniversity($MemberID_1);
$MemberUniv_2 = getUserUniversity($MemberID_2);
$MemberUniv_3 = getUserUniversity($MemberID_3);
$MemberUniv_4 = getUserUniversity($MemberID_4);


if($MemberUniv_1!= $UniversityID || 
   $MemberUniv_2 != $UniversityID || 
   $MemberUniv_3 != $UniversityID || 
   $MemberUniv_4 != $UniversityID) 
    header("location: ../index?error=universitiesDoNotMatch");


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
*/