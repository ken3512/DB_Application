<?php 
    $conn = new mysqli("localhost", "root", "");
    $sql = "drop database app;";

    $conn->query($sql);

    header("location: ../tools.php");
    ?>