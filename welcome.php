<?php
    include_once "header.php";
?>
    <h3 id="thankYou">Thank You,</h3>
    <?php
        if (isset($_GET["username"])) {
            $name = $_GET["username"];
            echo "<h2 id='name'>$name</h2>";
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