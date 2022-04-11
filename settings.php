<?php 
    include_once "header.php";
?>

<h1> <?php echo $_SESSION["Name"] . "'s" ?> User Settings</h1>
<button class="submitButton" onclick="location.href='changeUsername.php'">Change Username</button><br><br>
<button class="submitButton" onclick="location.href='changePassword.php'">Change Password</button><br><br>
<button class="submitButton" onclick="location.href='changeWebsiteAppearance.php'">Change Website Appearance</button><br><br>
<?php 
    include_once "footer.php";
?>