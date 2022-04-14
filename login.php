<?php 
    include_once "header.php";
?>

<section class="forms">
    <h2 class="primaryTitle">Login</h2> 
    <?php
        $errorMsg = "";
        if (isset($_GET["error"])) {
            // Handle the error message
            echo $_GET["error"];
        }
    ?>
    <form class="forms" action="api/login.php" method="post">
        <input class="textInput" type="text" name="Username" placeholder="Username..." required autofocus><br>
        <input class="textInput" type="password" name="Password" placeholder="Password..." required> <br>
        <p class="desc"> 
            Don't have an account? Sign up <a href="/signup.php">here</a>!
        </p>
        <button type="submit" name="submit" class="submitButton">Login</button>
    </form>
</section>

<?php 
    include_once "footer.php";
?>
