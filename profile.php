<?php 
    include_once "header.php";
    include_once "api/api_functions.php";
?>


<?php  
    // Display the unapproved RSOs to super admins
    if (isset($_SESSION["ID"])) {
        $userInfo = getUserInfoById($_SESSION["ID"]);
        echo '<div class="event"><h2 class="pageTitle">' . $userInfo["Name"] . '\'s Profile Page</h2><br>';
        echo '<p class="desc">Email: '. $userInfo["Gmail"] . '</p><br>';
        echo '<p class="desc">University: ' . getUserUniversityName($userInfo["UniversityID"]) . '</p><br>';
        echo '<p class="desc">User Status: ' . getMaxUserStatus($userInfo["ID"]) . "</p><br></div>";
        if (isSuperAdmin($_SESSION["ID"])) {
            echo '<h2 class="pageTitle">Approve RSOs for Super Admins:</h2>';
            getUnapprovedRSO($_SESSION["ID"]);
        }
    }
    else {
        header("location: ../index");
    }    
?>


<?php 
    include_once "footer.php";
?>