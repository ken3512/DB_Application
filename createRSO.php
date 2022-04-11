<?php
    include_once "header.php";
    include_once "api/api_functions.php";
    if (isset($_SESSION["ID"]))
        $UniversityID = getUserUniversity($_SESSION["ID"]);
?>
    <h2 class="pageTitle">Create a New RSO!</h2>
    <form class="forms" action="api/createRSO.php" method="POST">
        <input class="textInput" type="text" name="Name" placeholder="RSO Name"><br>
        <p>Select 4 Other users in your university to start a new RSO.</p>
        <select class="options" name="M1">
            <?php allStudents($UniversityID);?>
        </select><br>
        <select class="options" name="M2">
            <?php allStudents($UniversityID);?>
        </select><br>
        <select class="options" name="M3">
            <?php allStudents($UniversityID);?>
        </select><br>
        <select class="options" name="M4">
            <?php allStudents($UniversityID);?>
        </select><br>
        <button class="submitButton" type="submit" name="submit">Register RSO</button>
    </form>
<?php 
    include_once "footer.php";
?>

