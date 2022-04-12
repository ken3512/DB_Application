<?php
    include_once "header.php";
?>

<h1> <?php echo $_SESSION["Name"] . "'s" ?> User Settings</h1><br>
<h2> Change Password:</h2>

<form class="forms" action="api/changePassword.php" method="post">
    <input class="textInput" type="password" name="CurrentPass" placeholder="Current Password..." required><br>
    <input class="textInput" type="password" name="NewPass" placeholder="New Password..." required><br>
    <input class="textInput" type="password" name="ConfirmNewPass" placeholder="Confirm New Password..." required><br>
    <button type="submit" name="submit" class="submitButton">submit</button>
</form>

<?php 
    include_once "footer.php"; 
?>