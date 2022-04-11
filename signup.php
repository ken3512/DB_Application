<?php 
    include_once "header.php";
?>

<!-- Sign up form -->
<section class="forms">
    <h2 class="primaryTitle"> Sign Up</h2>
    <div class="formsDiv">
        
        <!-- Check for errors -->
        <?php
            $errorMsg = "";
            if (isset($_GET["error"])) {
                //handle the error
                switch ($_GET["error"]) {
                    case "signupInputIsEmpty":
                        $errorMsg = "You must fill in all fields!";
                        break;
                    case "usernameIsInvalid":
                        $errorMsg = "
                            <p>Username is invalid!</p>
                            <ul>
                                <li>Must start with a lowercase or uppercase letter.</li>
                                <li>Must be 6 to 32 characters in length.</li>
                                <li>Cannot contain any special characters.</li>
                            </ul>";
                        break;
                    case "passwordIsTooSimple":
                        $errorMsg = "
                            <p>Password is too simple!</p>
                            <ul>
                                <li>Must be between 8 and 32 characters.</li>
                                <li>Must contain a lowercase letter.</li>
                                <li>Must contain an uppercase letter.</li>
                                <li>Must contain a special character.</li>
                                <li>Must not contain a space.</li>
                            </ul>";
                        break;
                    case "passwordsDoNotMatch":
                        $errorMsg = "Passwords do not match! Please try again.";
                        break;
                    case "preparedStatementFailed":
                        $errorMsg = "Input invalid! Please try again.";
                        break;
                    case "usernameExists":
                        $errorMsg = "Username already exists! Please try again.";
                        break;
                    case "emailIsInvalid":
                        $errorMsg = "Email format is invalid! Please try again.";
                        break;
                    case "creationFailed":
                        $errorMsg = "User creation failed! Please try again.";
                        break;
                    default:
                        $errorMsg = $_GET["error"];
                        break;
                }
            }
            echo "<p>$errorMsg</p>";
        ?>

        <!-- Setup the form for signup -->
        <form action="api/registerUser.php" method="post">
            <select class="textInput" name="UniversityID">
                <?php allUniversity();?>
            </select>
            <br>
            <input class="textInput" type="text" name="Name" placeholder="Name..." required autofocus> <br>
            <input class="textInput" type="email" name="Gmail" placeholder="Gmail..." required autofocus> <br>
            <input class="textInput" type="phone" name="Phone" placeholder="Phone..." required autofocus> <br>
            <input class="textInput" type="password" name="Password" placeholder="Password..." required> <br>
            <input class="textInput" type="password" name="ConfirmPassword" placeholder="Confirm Password..." required> <br>
            <button type="submit" name="submit" id="signupButton">Submit</button>
        </form>
    </div>
</section>


<?php 
    include_once "footer.php";
?>