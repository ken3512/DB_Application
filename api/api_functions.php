
<?php  
include_once "helper_functions.php";

date_default_timezone_set('America/New_York');

function encryptionKey()
{
    return 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';
}

//ENCRYPT FUNCTION
function encryptthis($data, $key) 
{
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
    
    //DECRYPT FUNCTION
function decryptthis($data, $key)
{
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

function connectToDatabase() {
    $conn = mysqli_connect("localhost","Admin","HeighT#157s","App"); 
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // echo "Connected successfully";
    return $conn;
}

// Para
function changeUsername($UserID, $NewName) 
{
    $key = encryptionKey();

    if (usernameIsInvalid($NewName)) {
        header("location: ../changeUsername.php?error=newUsernameInvalid");
        return;
    }
    if (usernameExists($NewName, $NewName)) {
        header("location: ../changeUsername.php?error=usernameAlreadyExists");
        return;
    }
    // Only here if the $NewName is valid and the name doesn't already exist
    // Change the user's name in the database
    $conn = connectToDatabase();

    $sql = "Update Users SET Name = '$NewName' WHERE ID = $UserID;";
    $result = mysqli_query($conn, $sql);

    if ($result)  {
        echo "Successfully changed name";
        // session_start();
        $_SESSION["Name"] = $NewName;
        header("location: ../settings");
    }
    else {
        echo "Name change failed" . mysqli_error($conn);
        header("location: ../settings");
    }
    header("location: ../settings");
}

function passwordDoesNotMatchUser($UserID, $CurrentPass) 
{
    $result = true;
    
    $UserInfo = getUserInfoById($UserID);
    $passIsValid = password_verify($CurrentPass, $UserInfo["Password"]);
    if($passIsValid) {
        $result = false;
    }

    return $result;
}

function changePassword($UserID, $CurrentPass, $NewPass, $ConfirmNewPass) 
{
    $key = encryptionKey();
    if (passwordDoesNotMatchUser($UserID, $CurrentPass)) {
        header("location: ../changePassword.php?error=passwordDoesNotMatchUser");
        exit();
    }
    if (passwordsDoNotMatch($NewPass, $ConfirmNewPass)) {
        header("location: ../changePassword.php?error=passwordsDoNotMatch");
        exit();
    }
    if (passwordIsTooSimple($NewPass)) {
        header("location: ../changePassword.php?error=passwordIsTooSimple");
        exit();
    }

    // CurrentPass matches the user that is logged in.
    // The new password is complex enough
    // And the passwords match
    // Change the password in the database and replace it with $NewPass
    $hashedPwd = password_hash($NewPass, PASSWORD_DEFAULT);
    $conn = connectToDatabase();
    $sql = "Update Users SET Password = '$hashedPwd' WHERE ID = $UserID;";
    $result = mysqli_query($conn, $sql);
    if ($result)  {
        header("location: ../settings");
    }
    else {
        echo "Password change failed: " . mysqli_error($conn);
    }

}

function setUserWebsiteAppearance($UserID, $WebsiteAppearanceValue) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "Update Users SET ColorPreferences = $WebsiteAppearanceValue WHERE ID = $UserID;";
    $result = mysqli_query($conn, $sql);
    if ($result)  {
        header("location: ../settings");
    }
    else {
        echo "Name change failed" . mysqli_error($conn);
    }
}

function getUserWebsitePreferences($UserID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT ColorPreferences FROM Users WHERE ID = $UserID;";
    $result = mysqli_query($conn, $sql);
    if ($result)  {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            return $row["ColorPreferences"];
        }
    }
}

function getMaxUserStatus($UserID) 
{
    $key = encryptionKey();
    if (isSuperAdmin($UserID)) {
        return "Super Admin";
    }
    else if (isAdmin($UserID)) {
        return "RSO Admin";
    }
    else {
        return "Student";
    }
}

// Return true if the UserID is an Admin
// Return false is it is not
function isAdmin($UserID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT U.Name, R.Name FROM Users U, RSO R WHERE (U.ID = $UserID AND R.OwnerID = $UserID AND R.Status = 1);";
    $result = mysqli_query($conn, $sql);
    if ($result)  {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // echo "is admin";
            return true;
        }
        else {
            return false;
        }
    }
    else return false;
}

// Return true if the UserID is an Admin
// Return false is it is not
function isSuperAdmin($UserID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT Super FROM Users U WHERE U.ID = $UserID;";
    $result = mysqli_query($conn, $sql);
    if ($result)  {
        $row = mysqli_fetch_assoc($result);
        if ($row["Super"] == 1) {
            // echo "is super";
            return true;
        }
        else {
            return false;
        }
    }
    else return false;
}

// Return the data in the users table for the ID passed in
function getUserInfoById($UserID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Users U WHERE U.ID = $UserID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// Display the category options for creating an event 
function displayCategories() 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Categories;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo '
                <option value="' . $row["ID"] .'">' . $row["Name"] .'</option>
            '; 
        }
    }
}

// Return the row data for the admin in an RSO
function getRSOData($userID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM rso WHERE OwnerID = $userID;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    return $row;
}

function createEvent($EventName, $EventDescription, $EventCategory, $EventPrivacy, $ContactPhone, $ContactEmail, $EventLocationName, $EventLocationDescription, $userID) 
{
    $key = encryptionKey();

    $conn = connectToDatabase();
    // Add the location to the database and use it's Id top populate $EventLocationID
    // Then insert the values into the event database
    // $sql = "INSERT INTO `Location` (`Name`, `Description`) VALUES ('$EventLocationName', '$EventLocationDescription');";
    $sql = "INSERT INTO `Location` (`Name`, `Description`) VALUES (?, ?);";
    $stmt = $conn->prepare($sql);
    if(!$stmt) {
        echo "Location Insert Failed: " . mysqli_error($conn);
        exit();
    }

    $EventLocationName_enc = encryptthis($EventLocationName, $key);
    $EventLocationDescription_enc = encryptthis($EventLocationDescription, $key);
    

    $stmt->bind_param("ss", $EventLocationName_enc, $EventLocationDescription_enc);
    $stmt->execute();
    $stmt->get_result();

    // Get the location id of the location we just inserted
    $EventLocationID = $conn->insert_id;
    
    // Get the ForeignID
    // If the privacy is 0 or 1 set the ForeignID to the University
    // Else set the ForeignID to the RSO
    $rsoData = getRSOData($userID);
    if ($EventPrivacy == 0 || $EventPrivacy == 1) {
        $ForeignID = $rsoData["UniversityID"];
    }
    else {
        $ForeignID = $rsoData["ID"];
    }
    $sql = "INSERT INTO Events (`LocationID`, `EventCat`, `ForeignID`, `Name`, `Description`, `Privacy`, `ContactPhone`, `ContactEmail`)  VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);
    if(!$stmt) {
        echo "Prepared statement failed";
        exit();
    }

    $EventName_enc = encryptthis($EventName, $key);
    $EventDescription_enc = encryptthis($EventDescription, $key);
    $ContactPhone_enc = encryptthis($ContactPhone, $key);
    $ContactEmail_enc = encryptthis($ContactEmail, $key);


    $stmt->bind_param("iiississ", $EventLocationID, $EventCategory, $ForeignID, $EventName_enc, $EventDescription_enc, $EventPrivacy, $ContactPhone_enc, $ContactEmail_enc);
    $stmt->execute();
    $stmt->get_result();
    header("location: ../index.php");
}

function usernameExists($Name, $Gmail) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Users WHERE `Name` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=preparedStatementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $Name);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        return false;
    }
    mysqli_stmt_close($stmt);
}

function login($Name, $Password)
{
    $key = encryptionKey();
    $usernameExists = usernameExists($Name, $Name);

    if ($usernameExists === false) {
        header("location: ../login.php?error=invalidUsernameOrEmail");
        exit();
    }

    // The user exists so check if the password matches
    $passIsValid = password_verify($Password, $usernameExists["Password"]);
    if (!$passIsValid) {
        header("location: ../login.php?error=incorrectPassword");
        exit();
    } else {
        // Start the session and assign variables
        session_start();
        $_SESSION["ID"] = $usernameExists["ID"];
        $_SESSION["Name"] = $usernameExists["Name"];
        // Go to the account page of the user
        header("location: ../index.php"); 
        exit();
    }

}

function signup($UniversityID, $Name, $Gmail, $Phone, $Password)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "INSERT INTO Users(`UniversityID`, `Name`, `Gmail`, `Phone`, `Password`) VALUES (?, ?, ?, ?, ?);";

    $hashedPwd = password_hash($Password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare($sql);

    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }

    $Gmail_enc = encryptthis($Gmail, $key);
    $Phone_enc = encryptthis($Phone, $key);

    $stmt->bind_param("issss", $UniversityID, $Name, $Gmail_enc, $Phone_enc, $hashedPwd);
    $stmt->execute();
    $stmt->get_result();

    session_start();
    $_SESSION["ID"] = $conn->insert_id;
    $_SESSION["Name"] = $Name;
    header("location: ../welcome.php");
    exit();
}

function showEvents($UserID)
{
    $conn = connectToDatabase();
    $sql = "SELECT E.ID FROM Events E, Users U  WHERE U.ID = ? AND 
        ((U.Super =  1) OR 
        (E.Privacy = 0) OR 
        (E.Privacy = 1 AND EXISTS (SELECT O.ID FROM University O WHERE E.ForeignID = O.ID AND U.UniversityID = O.ID)) OR 
        (E.Privacy = 2 AND EXISTS (SELECT R.ID FROM Registered R WHERE R.UserID = U.ID AND R.RSOID = E.ForeignID)));";
    $stmt = $conn->prepare($sql);

    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }

    $stmt->bind_param("i", $UserID);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultCheck = mysqli_num_rows($result);
    
    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            FormatEvent($row['ID'], $UserID);
        }
    }

}

function showPublicEvents()
{
    $key = encryptionKey();
    $UserID = 0;
    $conn = connectToDatabase();
    $sql = "SELECT E.ID FROM Events E WHERE E.Privacy = 0;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            FormatEvent($row['ID'], $UserID);
        }
    }

}

function EventInfo($EventID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Events E WHERE E.ID = $EventID;";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    return $row;

}

function getLocationNameByLocationID($LocationID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT Name FROM Location WHERE ID = $LocationID;";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            return decryptthis($row["Name"], $key);
        }
    }

    echo "Error when trying to get location name: " . mysqli_error($conn);
    
}
function FormatEvent($EventID, $UserID)
{
    $key = encryptionKey();

    $info = EventInfo($EventID);
    echo '
        <div class="event" style="text-align: left;">
            <div class="inner_event">
                <div class="inner_inner_event">
                    <span class="event_desc eventName">'. decryptthis($info["Name"], $key) .'</span> <br>
                    <span class="event_desc">'. decryptthis($info["Description"], $key) .'</span><br><br>
                </div>
                <span class="event_desc">Phone: '. decryptthis($info["ContactPhone"], $key) .'</span>
                <span class="event_desc">Email: '. decryptthis($info["ContactEmail"], $key) .'</span><br>
                <span class="event_desc">Location: '. getLocationNameByLocationID($info["LocationID"]) .'</span><br> 
                <span class="event_desc" >Rating: '. rating($EventID) .'</span><br><br>
            </div>
    ';

    if($UserID != 0 && !isRated($EventID, $UserID))
    {
        echo '                
            <form action="api/rate.php" method="POST">
                <input type="hidden" name="EventID" value='.$EventID.'>
                <input type="radio" name="rating" value=1>
                <input type="radio" name="rating" value=2>
                <input type="radio" name="rating" value=3>
                <input type="radio" name="rating" value=4>
                <input type="radio" name="rating" value=5>
                <br>
                <p>&ensp;1&emsp;2&emsp;3&emsp;4&emsp;5&emsp;<p><br>
                <button class="commentSubmit" type="submit" name="submit">Rate</button>
            </form>';
    }

    echo '<br><p class="desc">Comments:<br></p>';
    
    echo getComments($EventID, $UserID);
    
    if($UserID != 0)
    {
        $UserInfo = getUserInfoById($UserID);
        $UserName = $UserInfo["Name"];
        echo '
            <form action="api/Comment.php" method="POST">
                <input type="hidden" name="EventID" value='. $EventID .'>
                <p class="desc"><br>'. $UserName .':</p>
                <textarea class="CommentEntry" name="Comment" rows="2" cols="20" placeholder="Text"></textarea>
                <br>
                <button class="commentSubmit" type="submit" name="submit">Comment</button>
            </form>
        ';
    }

    echo '
    </div>';
}

function stringifyStatus($status) 
{
    if ($status == 0) {
        return "Not Approved Yet";
    }
    else {
        return "Approved";
    }
}


function getAllRSO($UserID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT R.Name, R.Status, R.UniversityID FROM RSO R WHERE EXISTS (SELECT O.ID FROM Registered O WHERE O.UserID = $UserID AND O.RSOID = R.ID)";
    
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            FormatRSOs(decryptthis($row["Name"], $key), $row["Status"], $row["UniversityID"]);
        }
    }
    else {
        echo "<p class='desc'>Not in any RSOs. Click <a href='joinRSO.php'>here</a> to see joinable RSOs!</p>";
    }
}

function formatRSOs($Name, $Status, $UniversityID)
{
    echo '<p class="desc">RSO Name: ' . $Name . '</p><br>';
    echo '<p class="desc">RSO\'s University: ' . getUserUniversityName($UniversityID) . '</p><br>';
    echo '<p class="desc">RSO\'s Approval Status: ' . stringifyStatus($Status)  . '</p><br><br>';
}

function getRsoInfoByRsoId($RSOID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM RSO WHERE ID = $RSOID;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row)
        return $row;
    else 
        return null;
}

function isRegistered($RSOID, $MemberID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT R.ID FROM Registered R WHERE R.RSOID = $RSOID AND R.UserID = $MemberID;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    // Check if registration exists
    if($resultCheck > 0) return True;
    return False;
} 

function registerMember($RSOID, $MemberID)
{
    $key = encryptionKey();

    if(isRegistered($RSOID, $MemberID)) return true;

    $conn = connectToDatabase();
    $sql = "INSERT INTO Registered (RSOID, UserID) VALUES ($RSOID, $MemberID);";
    $result = mysqli_query($conn, $sql);

    // Return success boolean
    if($result) return True;
    return false;
} 

function unregisterMember($MemberID, $RSOID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "DELETE R FROM Registered R WHERE R.RSOID = $RSOID AND R.UserID = $MemberID;";
    $result = mysqli_query($conn, $sql);

    // Return success boolean
    if($result) return True;
    return false;
} 


function createRSO($UniversityID, $OwnerID, $Name, $MemberID_1, $MemberID_2, $MemberID_3, $MemberID_4)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "INSERT INTO RSO(UniversityID, OwnerID, Name) VALUES (?, ?, ?);";

    $stmt = $conn->prepare($sql);
    
    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }
    

    $Name_enc = encryptthis($Name, $key);

    $stmt->bind_param("iis", $UniversityID, $OwnerID, $Name_enc);
    $stmt->execute();
    
    $RSOID = $conn->insert_id;

    registerMember($RSOID, $MemberID_1);
    registerMember($RSOID, $MemberID_2);
    registerMember($RSOID, $MemberID_3);
    registerMember($RSOID, $MemberID_4);
    registerMember($RSOID, $OwnerID);
}

function comment($EventID, $UserID, $Comment)
{
    $key = encryptionKey();
    if(empty($Comment)) return;

    $conn = connectToDatabase();
    $sql = "INSERT INTO Comments (EventID, UserID, Text) VALUES (?, ?, ?)";
    
    // Execute prepared statement
    $stmt = $conn->prepare($sql);
    
    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }

    $stmt->bind_param("iis", $EventID, $UserID, $Comment);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return success boolean
    if($result) return True;
    return false;
}

function getComments($EventID, $UserID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT C.Text, U.Name, C.DataTimeUpdated, C.ID FROM Comments C, Users U WHERE C.EventID = $EventID AND (C.UserID = U.ID)";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
        while($row = mysqli_fetch_assoc($result)) {
            $date = new DateTime($row['DataTimeUpdated']);
            echo "<p>&emsp;[" . $date->format('m-d H:i') . "] <strong> ". $row['Name'] .": </strong> ". $row['Text'] . "</p><br>";
            displayEventCommentEditingButtons($EventID, $UserID, $row["ID"]);
        }
}

// function displayEventCommentEditingButtons($EventID, $UserID, $CommentID) {
//     $UserInfo = getUserInfoById($UserID);
//     if ($UserInfo["ID"] == $_SESSION["ID"]) {
//         echo "<div class='EditingOptions'>";
//         echo "
//             <form class='commentEditingForms' action='eventCommentEdit.php'  method='POST'>
//                 <input type='hidden' name='EventID' value='$EventID'>
//                 <input type='hidden' name='UserID' value='$UserID'>
//                 <input type='hidden' name='CommentID' value='$CommentID'>
//                 <button class='commentEditingButtons' type='submit' name='submit'>Edit</button>
//             </form>
//         ";
//         echo"   
//             <form class='commentEditingForms' action='api/eventCommentDelete.php' method='POST'>
//                 <input type='hidden' name='CommentID' value='$CommentID'>
//                 <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
//             </form>
//         ";
//         echo "</div>";

//     }    
// }
function displayEventCommentEditingButtons($EventID, $UserID, $CommentID) {
    
    $LoggedInUserInfo = getUserInfoById($_SESSION["ID"]);
    
    $conn = connectToDatabase();
    $sql = "SELECT UserID FROM Comments WHERE ID = $CommentID;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $CommentUserID = $row["UserID"];

    echo "<div class='EditingOptions'>";
    if ($LoggedInUserInfo['Super'] == 1) {
        if ($CommentUserID == $_SESSION["ID"]) {
            echo "
                <form class='commentEditingForms' action='eventCommentEdit.php'  method='POST'>
                    <input type='hidden' name='EventID' value='$EventID'>
                    <input type='hidden' name='UserID' value='$UserID'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Edit</button>
                </form>
            ";
            echo"   
                <form class='commentEditingForms' action='api/eventCommentDelete.php' method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
                </form>
            ";
        }
        else {
            echo"   
            <form class='commentEditingForms' action='api/eventCommentDelete.php' method='POST'>
                <input type='hidden' name='CommentID' value='$CommentID'>
                <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
            </form>
        ";
        }
    }
    else {
        if ($CommentUserID == $_SESSION["ID"]) {
            echo "
                <form class='commentEditingForms' action='eventCommentEdit.php'  method='POST'>
                    <input type='hidden' name='EventID' value='$EventID'>
                    <input type='hidden' name='UserID' value='$UserID'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Edit</button>
                </form>
            ";
            echo"   
                <form class='commentEditingForms' action='api/eventCommentDelete.php' method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
                </form>
            ";
        }
    }
    echo "</div>";
}


function deleteEventComment($CommentID) {
    $conn = connectToDatabase();
    $sql = "DELETE FROM Comments C WHERE C.ID = $CommentID;";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
        exit();
    } 
    else {
        header("location: ../events.php");
    }
}

    
function displayEventCommentEditing($EventID, $UserID, $CommentID) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Comments WHERE ID = $CommentID;";
    $result = mysqli_query($conn, $sql);
    
    if($result)
    {
        $EventInformation = EventInfo($EventID);
        $key = encryptionKey();
        $EventName = decryptthis($EventInformation["Name"], $key);
        $EventDescription =  decryptthis($EventInformation["Description"], $key);

        echo '
        <h2 class="pageTitle">Editing Comment:</h2>
        <div class="chatroom_outer">
        <div class="chatroom">
        
        <div class="inner_inner_event">
            <span class="event_desc eventName">'. $EventName .'</span> <br>
            <span class="event_desc">'. $EventDescription . '</span><br><br>
        </div>
        ';
        

        $row = mysqli_fetch_assoc($result);
        $UserInfo = getUserInfoById($row["UserID"]);
        $UserName = $UserInfo["Name"];
        echo '<p> '. $UserName .'\'s Old Comment:<br>&emsp;' . $row["Text"] . '</p>';
        echo '
        <div class="editingComment">
        <form action="api/eventCommentEdit.php" method="POST">
            <input type="hidden" name="CommentID" value='.$row["ID"].'>
            <textarea class="CommentEntry" name="NewComment" rows="4" cols="20" placeholder="New Comment..."></textarea><br>
            <button class="commentSubmit" type="submit" name="submit">Update</button>
        </form>
        </div>
        ';
        $date = new DateTime($row['DataTimeUpdated']);
        echo "<p>Last Updated: &emsp;[" . $date->format('m-d H:i') . "]</p>";

        echo '</div></div>';
    }
    else {
        echo mysqli_error($conn);
    }
}


function updateEventComment($CommentID, $NewComment) {
    $conn = connectToDatabase();
    $Date = date('Y-m-d H:i:s');
    $sql = "UPDATE Comments SET `Text` = '$NewComment', DataTimeUpdated = '$Date'  WHERE ID = $CommentID";
    $result = mysqli_query($conn, $sql);
    // Return success boolean
    if(!$result) {
        echo mysqli_error($conn);
    }
}

function isRated($EventID, $UserID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT R.ID FROM Ratings R WHERE R.EventID = $EventID AND R.UserID = $UserID;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    // Check if registration exists
    if($resultCheck > 0) return True;
    return False;
}

function rate($EventID, $UserID, $Rating)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    
    if(isRated($EventID, $UserID)) return true;
    
    $sql = "INSERT INTO Ratings (EventID, UserID, Rating) VALUES ($EventID, $UserID, $Rating)";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    // Check if registration exists
    if($resultCheck > 0) return True;
    return False;
}

function rating($EventID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT AVG(R.Rating) Rating FROM Ratings R WHERE R.EventID = $EventID;";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if($row["Rating"]) return $row["Rating"];
    else return 'Unrated';
}

function getUserUniversityName($UniversityID) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT Name FROM University WHERE ID = $UniversityID;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    return $row["Name"];
}

function getUserUniversity($UserID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT U.UniversityID FROM Users U WHERE U.ID = $UserID;";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    return $row["UniversityID"];
}

function approveRSO($UserID, $RSOID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "UPDATE RSO R SET R.Status = 1 WHERE R.ID = $RSOID AND EXISTS (SELECT U.ID FROM Users U WHERE U.ID = $UserID AND U.Super = 1);";

    mysqli_query($conn, $sql);
} 

function getUnapprovedRSO($UserID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT R.ID, R.Name FROM  RSO R WHERE Status = 0 AND EXISTS (SELECT U.ID FROM Users U WHERE U.ID = $UserID AND U.Super = 1);";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $resultCheck = mysqli_num_rows($result);
        
        if($resultCheck > 0)
            while($row = mysqli_fetch_assoc($result))
                FormatApproval($row["ID"], decryptthis($row["Name"], $key));
    }
}

function FormatApproval($RSOID, $RSOName)
{
    echo "<form class='forms' action='api/approveRSO.php' method='POST'>
        <input type='hidden' name='RSOID' value=$RSOID><h3>" . $RSOName . "</h3><button class='submitButton' type='submit' name='submit'>Approve</button>
        </form>";
}

function allStudents($UniversityID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT U.ID, U.Name FROM  Users U WHERE U.UniversityID = $UniversityID;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    FormatCreateRSO(0,"-----------------------");
    
    if($resultCheck > 0)
        while($row = mysqli_fetch_assoc($result))
            FormatCreateRSO($row["ID"], $row["Name"]);
}

function FormatCreateRSO($UserID, $Name)
{
    echo '<option value="'. $UserID .'">'. $Name .'</option>';
}

function allUniversity()
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT U.ID, U.Name FROM  University U;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    FormatUniversites(0,"-----------------------");
    
    if($resultCheck > 0)
        while($row = mysqli_fetch_assoc($result))
            FormatCreateRSO($row["ID"], $row["Name"]);
}

function FormatUniversites($UniversityID, $Name)
{
    echo '<option value="'. $UniversityID .'">'. $Name .'</option>';
}

function allRSO($UniversityID, $UserID)
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT R.ID, R.Name FROM  RSO R WHERE R.UniversityID = $UniversityID
    AND NOT EXISTS 
    (SELECT O.ID FROM Registered O WHERE O.UserID = $UserID AND O.RSOID = R.ID);";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    
    if($resultCheck > 0)
        while($row = mysqli_fetch_assoc($result))
            FormatJoinRSO($row["ID"], decryptthis($row["Name"], $key));
}

function FormatJoinRSO($RSOID, $Name)
{
    echo $Name;
    echo'
    <form class = "forms" action="api/registerMember.php" method="POST">
        <input type="hidden" name="RSOID" value=' . $RSOID . '>
        <button type="submit" class="submitButton" name="submit">Join</button>
    </form>';
}

//
// Chatroom Comments
//

// Insert the $Comment passed in into the chatroom comments table
// with the $UserID that was passed in 
function insertChatroomComment($UserID, $Comment) 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "INSERT INTO ChatroomComments (UserID, Comment) VALUES (?, ?)";
    
    // Execute prepared statement
    $stmt = $conn->prepare($sql);
    
    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }

    $Comment_enc = encryptthis($Comment, $key);

    $stmt->bind_param("is", $UserID, $Comment_enc);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return success boolean
    if($result) return True;
    return false;
}

// Echo every comment for the chatroom
// Starting with the most recent
function displayAllChatroomComments() 
{
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM ChatroomComments ORDER BY ID DESC;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $commentID = $row['ID'];
            $UserInfo = getUserInfoById($row["UserID"]);
            $UserName = $UserInfo["Name"];
            $date = new DateTime($row['DataTimeUpdated']);
            echo "
                <p>&emsp;[" . $date->format('m-d H:i') . "] ". checkEdited($row['DataTimeCreated'], $row['DataTimeUpdated']) ." <strong> ". $UserName .": </strong> ". decryptthis($row['Comment'], $key) . "</p>
            ";
            displayCommentOptions($commentID, $UserInfo);
        }
    }
    else {
        echo mysqli_error($conn);
    }
}

function checkEdited($DataTimeCreated, $DataTimeUpdated) {
    if ($DataTimeCreated != $DataTimeUpdated) {
        return "(edited)";
    }
}
function displayCommentOptions($CommentID, $UserInfo) {
    echo "<div class='EditingOptions'>";

    $LoggedInUserInfo = getUserInfoById($_SESSION["ID"]);

    if ($LoggedInUserInfo['Super'] == 1) {
        if ($UserInfo["ID"] == $_SESSION["ID"]) {
            echo "
                <form class='commentEditingForms' action='editComment.php'  method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Edit</button>
                </form>
            ";
            echo"   
                <form class='commentEditingForms' action='api/deleteComment.php' method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
                </form>
            ";
        }
        else {
            echo"   
                <form class='commentEditingForms' action='api/deleteComment.php' method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
                </form>
            ";
        }
    }
    else {
        if ($UserInfo["ID"] == $_SESSION["ID"]) {
            echo "
                <form class='commentEditingForms' action='editComment.php'  method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Edit</button>
                </form>
            ";
            echo"   
                <form class='commentEditingForms' action='api/deleteComment.php' method='POST'>
                    <input type='hidden' name='CommentID' value='$CommentID'>
                    <button class='commentEditingButtons' type='submit' name='submit'>Delete</button>
                </form>
            ";
        }
    }
    echo "</div>";
}

function deleteComment($CommentID) {
    $conn = connectToDatabase();
    $sql = "DELETE FROM ChatroomComments C WHERE C.ID = $CommentID;";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo mysqli_error($conn);
        exit();
    } 
    else {
        header("location: ../index.php");
    }
}
        
function displayEditingComment($CommentID) {
    $key = encryptionKey();
    $conn = connectToDatabase();
    $sql = "SELECT * FROM ChatroomComments WHERE ID = $CommentID;";
    $result = mysqli_query($conn, $sql);
    
    if($result)
    {
        echo '
            <h2 class="pageTitle">Editing Comment:</h2>
            <div class="chatroom_outer">
                <div class="chatroom">
        ';
        
        $row = mysqli_fetch_assoc($result);
        $UserInfo = getUserInfoById($row["UserID"]);
        $UserName = $UserInfo["Name"];
        echo $UserName . '<br>';
        echo '<p>Old Comment:<br>&emsp;' . decryptthis($row["Comment"], $key) . '</p>';
        echo '
        <div class="editingComment">
        <form action="api/editComment.php" method="POST">
            <input type="hidden" name="CommentID" value='.$row["ID"].'>
            <textarea class="CommentEntry" name="NewComment" rows="4" cols="20" placeholder="New Comment..."></textarea><br>
            <button class="commentSubmit" type="submit" name="submit">Update</button>
        </form>
        </div>
        ';
        $date = new DateTime($row['DataTimeUpdated']);
        echo "<p>Last Updated: &emsp;[" . $date->format('m-d H:i') . "]</p>";

        echo '</div></div>';
    }
    else {
        echo mysqli_error($conn);
    }
}

function updateComment($CommentID, $NewComment) {
    $key = encryptionKey();
    $conn = connectToDatabase();
    $NewComment_enc = encryptthis($NewComment, $key);
    $Date = date('Y-m-d H:i:s');
    $sql = "UPDATE ChatroomComments SET Comment = '$NewComment_enc', DataTimeUpdated = '$Date'  WHERE ID = $CommentID";
    $result = mysqli_query($conn, $sql);
    // Return success boolean
    if(!$result) {
        echo mysqli_error($conn);
    }
}
