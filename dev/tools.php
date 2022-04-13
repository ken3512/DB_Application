<?php
    include_once "header.php";
?>
    <div class="main">
        <h1>Dev Tools Page</h1>
        <form class="forms" action="../api/insertTestData.php" method="POST">
            <button class="submitButton" name="submit" type="submit">Insert Test Data</button>
        </form>
    </div>
<?php
    include_once "footer.php";
?>