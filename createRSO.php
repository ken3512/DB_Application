<?php
    include_once "header.php";
    include_once "api/api_functions.php";
    if (isset($_SESSION["ID"]))
        $UniversityID = getUserUniversity($_SESSION["ID"]);
?>
    <form action="api/createRSO.php" method="POST">
        <input type="text" name="Name" placeholder="RSO Name"><br>
        <select class="options" name="M1">
            <?php allStudents($UniversityID);?>
        </select>
        <select class="options" name="M2">
            <?php allStudents($UniversityID);?>
        </select>
        <select class="options" name="M3">
            <?php allStudents($UniversityID);?>
        </select>
        <select class="options" name="M4">
            <?php allStudents($UniversityID);?>
        </select><br>
        <button type="submit" name="submit">Register RSO</button>
    </form>
<?php 
    include_once "footer.php";
?>

