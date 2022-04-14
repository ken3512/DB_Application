<?php
    include_once "header.php";
?>
    <div class="main">
        <h1>Dev Tools Page</h1>
        <form class="forms" action="apiDev/insertTestData.php" method="POST">
            <button class="submitButton" name="submit" type="submit">Insert Test Data</button>
        </form>
        <br><br>
        <form class="forms" action="apiDev/Setupdatabase.php" method="POST">
            <button class="submitButton" name="submit" type="submit">Database Setup</button>
        </form>

        <br><br>
        <form class="forms" action="apiDev/dropdatabase.php" method="POST">
            <button class="submitButton" name="submit" type="submit">Drop database</button>
        </form>
        <br><br>   
        <form class="forms" action="apiDev/MakeAdmin.php" method="POST">
            <button class="submitButton" name="submit" type="submit">Become Super Admin</button>
        </form>
        <br><br>
        <form class="forms" action="apiDev/goHome.php" method="POST">
            <button class="submitButton" name="submit" type="submit">Go Home</button>
        </form>


    </div>
<?php
    include_once "footer.php";
?>