<?php
    session_start();
    include_once "../api/api_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Project</title>
    
    <?php
        if (isset($_SESSION["ID"])) {
            $prefValue = getUserWebsitePreferences($_SESSION["ID"]);
            if ($prefValue == 1) { // Dark mode
                echo '
                    <link rel="stylesheet" href="styles/dark/main.css">
                ';
            }
            else { // Light Mode
                echo '
                    <link rel="stylesheet" href="styles/light/main.css">
                ';
            }
        } else { // Default is light mode if the user isn't logged in
            echo '
                <link rel="stylesheet" href="styles/light/main.css">
            ';
        }
    ?>
</head>
<body>