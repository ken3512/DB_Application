<?php
    include_once "header.php";
?>
    <!-- 
        Check if the user is an admin/superAdmin as 
        only an admin can create events.
    -->
    <?php
        include_once "api/api_functions.php";
        if (!isAdmin($_SESSION["ID"]) || !isSuperAdmin($_SESSION["ID"])) {
            echo "Not an admin";
            header("location: ../index");
        }
    ?>
    <form action="api/createEvent.php">
        <input type="text" name="LocationID" placeholder="LocationID"> <br>
        <button type="submit" name="submit">Create Event/button>
    </form>
    <select name="housepets">
        <option value="cat">Cat</option>
        <option value="dog">Dog</option>
        <option value="llama">Llama</option>
        <option value="rabbit">Rabbit</option>
        <option value="animal">Animal</option>
    </select>
    </form>
<?php 
    include_once "footer.php";
?>