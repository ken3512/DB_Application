<?php
    include_once "header.php";
?>
    <div class="event-feed">
        <?php
            if (isset($_SESSION["ID"])) {
                showEvents($_SESSION["ID"]);
            } 
            else {
                showPublicEvents();
            }
        ?>
    </div>
<?php 
    include_once "footer.php";
?>