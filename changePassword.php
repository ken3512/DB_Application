<?php
    include_once "header.php";
?>

<h1> <?php echo $_SESSION["Name"] . "'s" ?> User Settings</h1><br>
<h2> Change Password:</h2>

<form class="forms" action="api/settings.php" method="post">
    <input class="textInput" type="text" name="UsernameChange" placeholder="Current Password..."><br>
    <input class="textInput" type="text" name="UsernameChange" placeholder="New Password..."><br>
    <input class="textInput" type="text" name="UsernameChange" placeholder="Confirm New Password..."><br>
    <button type="submit" name="submit" class="submitButton">submit</button>
</form>

<?php 
    include_once "footer.php"; 
?>