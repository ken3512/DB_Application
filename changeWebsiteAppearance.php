<?php
    include_once "header.php";
?>

<h1> <?php echo $_SESSION["Name"] . "'s" ?> User Settings</h1><br>
<h2> Change Website Appearance:</h2>
<form class="forms" action="api/changeWebsiteAppearance.php" method="post">
    <select class="textInput" name="WebsiteAppearanceValue">
        <!-- <option value="none" selected disabled hidden>Select an Option</option> -->
        <option value="0">[Default] Light Mode</option>
        <option value="1">Dark Mode</option>
    </select><br>
    <button type="submit" name="submit" class="submitButton">submit</button>
</form>

<?php 
    include_once "footer.php"; 
?>