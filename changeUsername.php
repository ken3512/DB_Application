<?php
    include_once "header.php";
?>

<h1> <?php echo $_SESSION["Name"] . "'s" ?> User Settings</h1><br>
<h2> Change Username:</h2>
<?php
    $errorMsg = "";
    if (isset($_GET["error"])) {
        // Handle the error message
        echo $_GET["error"];
    }
?>
<form class="forms" action="api/changeUsername.php" method="post">
    <input class="textInput" type="text" name="UsernameChange" placeholder="New Username..." required><br>
    <button type="submit" name="submit" class="submitButton">submit</button>
</form>

<?php 
    include_once "footer.php"; 
?>