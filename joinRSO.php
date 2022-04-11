<?php
    include_once "header.php";
    include_once "api/api_functions.php";
    if (isset($_SESSION["ID"])) 
        $UniversityID = getUserUniversity($_SESSION["ID"]);

        allRSO($UniversityID, $_SESSION["ID"]);
?>

    
<?php 
    include_once "footer.php";

/*
<form class="forms" action="api/registerMember.php" method="POST">
    <input type="hidden" name="RSOID" value=7>
    <button type="submit" name="submit">Join</button>
</form>
*/
?>