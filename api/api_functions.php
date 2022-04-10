
<?php  

function connectToDatabase() 
{
    $conn = mysqli_connect("localhost","Admin","HeighT#157s","App"); 

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // echo "Connected successfully";
    return $conn;
}

function usernameExists($Name, $Gmail) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Users WHERE `Name` = ? OR `Gmail` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=preparedStatementFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $Name, $Gmail);
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

function login($Gmail, $Password)
{
    $usernameExists = usernameExists($Gmail, $Gmail);

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
    $conn = connectToDatabase();
    $sql = "INSERT INTO Users(`UniversityID`, `Name`, `Gmail`, `Phone`, `Password`) VALUES (?, ?, ?, ?, ?);";

    $hashedPwd = password_hash($Password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare($sql);

    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }

    $stmt->bind_param("issss", $UniversityID, $Name, $Gmail, $Phone, $hashedPwd);
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
        (E.Privacy =  0) OR 
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
            FormatEvent($row['ID']);
        }
    }

}

function EventInfo($EventID)
{
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Events E WHERE E.ID = $EventID;";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    return $row;

}

function FormatEvent($EventID)
{
    $info = EventInfo($EventID);
    echo '
        <div class="event">
                <span class="name">'. $info["Name"] .'</span> <br>
                <span class="description">'. $info["Description"] .'</span> <br>
                <span class="contact_phone">Phone: '. $info["ContactPhone"] .'</span>
                <span class="contact_email">Email: '. $info["ContactEmail"] .'</span>
                <span class="location_id">Location: '. $info["LocationID"] .'</span> 
        </div>
    ';
    
}

function isRegistered($RSOID, $MemberID)
{
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
    $conn = connectToDatabase();
    $sql = "DELETE R FROM Registered R WHERE R.RSOID = $RSOID AND R.UserID = $MemberID;";
    $result = mysqli_query($conn, $sql);

    // Return success boolean
    if($result) return True;
    return false;
} 


function createRSO($UniversityID, $OwnerID, $Name, $MemberID_1, $MemberID_2, $MemberID_3, $MemberID_4)
{
    $conn = connectToDatabase();
    $sql = "INSERT INTO RSO(UniversityID, OwnerID, Name) OUTPUT INSERTED.ID VALUES (?, ?, ?);";

    $stmt = $conn->prepare($sql);
    
    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }
    
    $stmt->bind_param("iis", $UniversityID, $OwnerID, $Name);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = mysqli_fetch_array($result);
    
    $RSOID = $row["ID"];

    registerMember($RSOID, $MemberID_1);
    registerMember($RSOID, $MemberID_2);
    registerMember($RSOID, $MemberID_3);
    registerMember($RSOID, $MemberID_4);
    registerMember($RSOID, $OwnerID);
}

function comment($EventID, $UserID, $Comment)
{
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

function getComments($EventID)
{
    $conn = connectToDatabase();
    $sql = "SELECT C.Text FROM Comments C WHERE C.EventID = ?";

    $stmt = $conn->prepare($sql);
    
    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }

    $stmt->bind_param("i", $EventID);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
        while($row = mysqli_fetch_assoc($result))
            echo $row['Text'] . "<br>";
}

function isRated($EventID, $UserID)
{
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
    $conn = connectToDatabase();
    $sql = "SELECT AVG(R.Rating) Rating FROM Ratings R WHERE R.EventID = $EventID;";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    return $row["Rating"];
}


function createEvent($LocationID, $EventCat, $ForeignID, $Name, $Description, $Privacy, $ContactPhone, $ContactEmail)
{
    $conn = connectToDatabase();
    $sql = "INSERT INTO RSO (LocationID, EventCat, ForeignID, Name, Description, Privacy, ContactPhone, ContactEmail)  VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $conn->prepare($sql);
    
    if(!$stmt) 
    {
        echo "Prepared statement failed";
        exit();
    }
    
    $stmt->bind_param("iiisssiss", $LocationID, $EventCat, $ForeignID, $Name, $Description, $Privacy, $ContactPhone, $ContactEmail);
    $stmt->execute();
}

function test()
{
    $sql = "SELECT E.Name FROM Events E, Users U  WHERE U.ID = 5 AND ((U.Super =  1) OR (E.Privacy =  0) OR (E.Privacy = 1 AND EXISTS (SELECT O.ID FROM University O WHERE E.ForeignID = O.ID AND U.UniversityID = O.ID)) OR (E.Privacy = 2 AND EXISTS (SELECT R.ID FROM Registered R WHERE R.UserID = U.ID AND R.RSOID = E.ForeignID)));";
    $conn = connectToDatabase();

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
        while($row = mysqli_fetch_assoc($result))
            echo $row['Name'] . "<br>";
}

function getUserUniversity($UserID)
{
    $conn = connectToDatabase();
    $sql = "SELECT U.UniversityID FROM Users U WHERE U.ID = $UserID;";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    return $row["UniversityID"];
}

function approveRSO($UserID, $RSOID)
{
    $conn = connectToDatabase();
    $sql = "UPDATE RSO R SET R.Status = 1 WHERE R.ID = $RSOID AND EXISTS (SELECT U.ID FROM Users U WHERE U.ID = $UserID AND U.Super = 1);";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    // Check if registration exists
    if($resultCheck > 0) return True;
    return False;
} 

?>


