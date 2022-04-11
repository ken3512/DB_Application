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
    <?php
        if (isset($_SESSION["ID"])) {
            $prefValue = getUserWebsitePreferences($_SESSION["ID"]);
            if ($prefValue == 0) { // Dark mode
                echo '
                    <link rel="stylesheet" href="styles/dark/main.css">
                    <link rel="stylesheet" href="styles/dark/dropdown.css">
                    <link rel="stylesheet" href="styles/dark/forms.css">
                    <link rel="stylesheet" href="styles/dark/welcome.css">
                    <link rel="stylesheet" href="styles/dark/sidebar.css">
                    <link rel="stylesheet" href="styles/dark/events.css">
                    <link rel="stylesheet" href="styles/dark/rso.css">
                ';
            }
            else { // Light Mode
                echo '
                    <link rel="stylesheet" href="styles/light/main.css">
                    <link rel="stylesheet" href="styles/light/dropdown.css">
                    <link rel="stylesheet" href="styles/light/forms.css">
                    <link rel="stylesheet" href="styles/light/welcome.css">
                    <link rel="stylesheet" href="styles/light/sidebar.css">
                    <link rel="stylesheet" href="styles/light/events.css">
                    <link rel="stylesheet" href="styles/light/rso.css">
                ';
            }
        } else { // Default is dark mode if the user isn't logged in
            echo '
                <link rel="stylesheet" href="styles/dark/main.css">
                <link rel="stylesheet" href="styles/dark/dropdown.css">
                <link rel="stylesheet" href="styles/dark/forms.css">
                <link rel="stylesheet" href="styles/dark/welcome.css">
                <link rel="stylesheet" href="styles/dark/sidebar.css">
                <link rel="stylesheet" href="styles/dark/events.css">
                <link rel="stylesheet" href="styles/dark/rso.css">
            ';
        }
    ?>
    
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
                        echo '<a href="/signup">Sign Up</a>';
                        echo '<a href="/login">Login</a>';
                        echo '<a href="events">See All Events</a>';
                    } 
                    else {
                        echo '<a href="createRSO.php">Create New RSO</a>';
                        if (isAdmin($_SESSION["ID"]) || isSuperAdmin($_SESSION["ID"])) {
                            echo '<a href="createEvent.php">Create New Event</a>';
                        }
                        echo '<a href="joinRSO">Join New RSO</a>';
                        echo '<a href="events">See All Events</a>';
                        echo '<a href="/profile">Profile</a>';
                        echo '<a href="/settings">Settings</a>';
                        echo '<a href="/api/logout">Logout</a>';
                    } 
                ?>
            </div>
            <script src="/scripts/dropdown.js"></script>
        </div>
        <div class="navbar-right">
            <a href="/index">Club Event Organizer</a>
        </div>  
    </div>
    
    <div class="navbar2">
        
    </div>
    <div class="event-feed">
        
        