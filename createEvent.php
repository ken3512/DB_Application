<?php
    include_once "header.php";
?>
    <!-- 
        Check if the user is an admin/superAdmin as 
        only an admin can create events.
    -->
    <?php
        include_once "api/api_functions.php";
        if (!isAdmin($_SESSION["ID"]) && !isSuperAdmin($_SESSION["ID"])) {
            header("location: ../index");
        }
    ?>
    <h2 class="pageTitle">Create a New Event!</h2>

    <?php
        $errorMsg = "";
        if (isset($_GET["error"])) {
            // Handle the error message
            echo $_GET["error"];
        }
    ?>
    
    <form class="forms" action="api/createEvent.php" method="POST">
        <?php
            if (isset($_SESSION["ID"]))
                displayOwnedRSOs($_SESSION["ID"]);
        ?>
        <input class="textInput" type="text" name="EventName" placeholder="Event Name..." required><br>
        <input class="textInput" type="text" name="EventDescription" placeholder="Event Description..." required><br>
        
        <!-- <span>If phone and email is left blank, the user's phone and email will be used:</span><br> -->
        <input class="textInput" type="text" name="ContactPhone" placeholder="Contact Phone..."><br>
        <input class="textInput" type="text" name="ContactEmail" placeholder="Contact Email..."><br>
        
        <!-- Location -->
        <input class="textInput" type="text" name="EventLocationName" placeholder="Location Name..." required ><br>
        <input class="textInput" type="text" name="EventLocationDescription" placeholder="Location Description..." required ><br>



        <label for="EventCategory">Category:</label>
        <select name="EventCategory">
            <?php
                displayCategories();
            ?>    
        </select><br>
        <label for="EventPrivacy">Privacy:</label>
        <select name="EventPrivacy">
            <option value="0">Public</option>
            <option value="1">Private</option>
            <option value="2">RSO</option>
        </select><br>
        <button class="submitButton" type="submit" name="submit">Create Event</button>
    </form>
    
    </form>
<?php 
    include_once "footer.php";
?>