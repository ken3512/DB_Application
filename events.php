<?php
    include_once "header.php";
?>
    <?php
        if (isset($_SESSION["ID"])) {
            showEvents($_SESSION["ID"]);
        } 
        else {
            showPublicEvents();
        }
    ?>
<?php 
    include_once "footer.php";
?>