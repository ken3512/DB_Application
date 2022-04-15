<?php
    include_once "header.php";
    include_once "api/api_functions.php";
    if (isset($_SESSION["ID"])) 
        $UniversityID = getUserUniversity($_SESSION["ID"]);
?>
        
    <h2 class="pageTitle">Create a New RSO!</h2>
    <?php
        $errorMsg = "";
        if (isset($_GET["error"])) {
            // Handle the error message
            echo $_GET["error"];
        }
    ?>
    <form class="forms" action="api/createRSO.php" method="POST">
        <input class="textInput" type="text" name="Name" placeholder="RSO Name" required><br>
        <button class="submitButton" type="submit" name="submit">Register RSO</button>
    </form>
<?php 
    include_once "footer.php";
?>

