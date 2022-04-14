<?php 
    include_once "../../api/api_functions.php";
    $conn = connectToDatabase();

    session_start();
    if(!isset($_SESSION["ID"])) header("location: ../tools.php?error=NotLoggedIn");

    $id = $_SESSION["ID"];

    $sql = "UPDATE Users U SET U.Super = 1 WHERE U.ID = $id;";

    mysqli_query($conn, $sql);

    header("location: ../tools.php");?>