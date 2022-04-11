<?php
    include_once "header.php";
?>

<h2 class="pageTitle">Club Event Organizer Home Page!</h2>
<?php
    if (!isset($_SESSION["ID"])) {
        echo '
            <p class="desc">Sign up <a href="signup.php">here</a> to make a new account!</p>
            <p class="desc">If you already have an account you can login <a href="login.php">here</a>.</p>
            <p class="desc">Or see all the public events <a href="events.php">here</a>!</p>
            ';
        }
        ?>
<?php
    include_once "footer.php";
?>
