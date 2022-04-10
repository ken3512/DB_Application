
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
    if (!$stmt) {
        echo "stmt error";
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
    echo $info["Name"] . "<br>";
    echo $info["ID"] . "<br>";
    echo $info["ContactPhone"] . "<br>";
    echo $info["ContactEmail"] . "<br>";
    echo $info["NumRat"] . "<br>";
    echo $info["WeighRat"] . "<br>";
    echo $info["LocationID"] . "<br>";
    echo $info["Description"] . "<br><br>";
    getComments($EventID);
}

function registerMember($MemberID, $RSOID)
{
    
} 

function unregisterMember($MemberID, $RSOID)
{
    
} 

function createRSO($OwnerID, $MemberID_1, $MemberID_2, $MemberID_3, $MemberID_4)
{

}

function comment($EventID, $UserID, $Comment)
{
    $conn = connectToDatabase();
    $sql = "INSERT INTO Comments (EventID, UserID, Text) VALUES (?, ?, ?)";    
}

function getComments($EventID)
{
    $conn = connectToDatabase();
    $sql = "SELECT C.Text FROM Comments C WHERE C.EventID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $EventID);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo $row['Name'] . "<br>";
        }
    }
}


function rate($EventID, $UserID, $Rating)
{
    $conn = connectToDatabase();
    $sql = "INSERT INTO Ratings (EventID, UserID, Rating) VALUES (?, ?, ?)";
}

function createEvent()
{
    $conn = connectToDatabase();
    $sql = "";
}

function test()
{
    $sql = "SELECT E.Name FROM Events E, Users U  WHERE U.ID = 5 AND ((U.Super =  1) OR (E.Privacy =  0) OR (E.Privacy = 1 AND EXISTS (SELECT O.ID FROM University O WHERE E.ForeignID = O.ID AND U.UniversityID = O.ID)) OR (E.Privacy = 2 AND EXISTS (SELECT R.ID FROM Registered R WHERE R.UserID = U.ID AND R.RSOID = E.ForeignID)));";
    $conn = connectToDatabase();

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo $row['Name'] . "<br>";
        }
    }

}

?>


