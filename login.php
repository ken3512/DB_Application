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
    <form action="api/login.php" method="post">
        <input class="textInput" type="text" name="Gmail" placeholder="Username/Email..." required autofocus><br>
        <input class="textInput" type="password" name="Password" placeholder="Password..." required> <br>
        <p id="noAccountMessage"> 
            Don't have an account? Sign up <a href="/signup.php">here</a>!
        </p>
        <button type="submit" name="submit" class="submitButton">Login</button>
    </form>
</section>

<?php 
    include_once "footer.php";
?>
