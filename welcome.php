<?php
    include_once "header.php";
?>
    <h3 id="thankYou">Thank You,</h3>
    <?php
        if (isset($_SESSION["Name"])) {
            $Name = $_SESSION["Name"];
            echo "<h2 id='name'>$Name</h2>";
        }
        else {
            header("location: ../login.php");
            exit();
        }
    ?>
    <h3 id="thankYouMessage">For Signing Up!</h3>
<?php
    include_once "footer.php";
?>