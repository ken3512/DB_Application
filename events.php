<?php
    include_once "header.php";
?>
    <?php
        if (isset($_SESSION["ID"])) {
            showEvents($_SESSION["ID"]);
        }
    ?>
<?php 
    include_once "footer.php";
?>