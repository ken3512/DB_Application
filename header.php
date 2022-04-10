<?php
    include_once 'api/api_functions.php';
    session_start();
?>

<!-- Head -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Styles -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dropdown.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/welcome.css">
    <link rel="stylesheet" href="styles/sidebar.css">

</head>
<!-- Body -->
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="dropdown">
            <!-- Dropdown logic -->
            <button onclick="myFunction()" class="drop-btn">
                <img class="drop-btn" id="menuIcon" src="https://img.icons8.com/ios-filled/50/000000/menu--v1.png"/>
            </button>
            <div id="myDropdown" class="dropdown-content">
                <?php
                    if (!isset($_SESSION["ID"])) {
                        echo '<a href="/signup.php">Sign Up</a>';
                        echo '<a href="/login.php">Login</a>';
                    } 
                    else {
                        echo '<a href="/profile.php">Profile</a>';
                        echo '<a href="/settings.php">Settings</a>';
                        echo '<a href="/api/logout.php">Logout</a>';
                    } 
                ?>
            </div>
            <script src="/scripts/dropdown.js"></script>
        </div>
        <div class="navbar-right">
            <a href="/index.php">Club Event Organizer</a>
        </div>  
    </div>
    <div class="navbar2">
        <a href="createRSO.php">Create New RSO</a><br>
    </div>
    <div class="navbar2">
        <a href="events.php">See All Events</a><br>
    </div>
    <?php
        if (isset($_SESSION["ID"])) {
            echo $_SESSION["ID"] . "<br>";
            echo $_SESSION["Name"] . "<br>";
        }
    ?>