<?php 
    include_once "../../api/api_functions.php";


    function UniversityTestData($Name, $GmailAt)
    {
        $conn = connectToDatabase();
        $sql = "INSERT INTO University (Name, GmailAt) VALUES (?, ?);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $Name, $GmailAt);
        $stmt->execute();
    }

    UniversityTestData("University of Central Florida", "@knights.ucf.edu");
    UniversityTestData("Florida State University", "@fsu.edu");

    function UsersTestData($UniversityID, $Super, $Username, $Name, $Gmail, $Password, $Phone) 
    {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO Users(`UniversityID`, `Super`, `Username`, `Name`, `Gmail`, `Phone`, `Password`) VALUES (?, ?, ?, ?, ?, ?, ?);";
        $stmt = $conn->prepare($sql);

        $Gmail_enc = encryptthis($Gmail, $key);
        $Password_enc = password_hash($Password, PASSWORD_DEFAULT);
        $Phone_enc = encryptthis($Phone, $key);
        $Name_enc = encryptthis($Name, $key);

        $stmt->bind_param("iisssss", $UniversityID, $Super, $Username, $Name_enc, $Gmail_enc, $Phone_enc, $Password_enc);
        $stmt->execute();
    }

    UsersTestData(1, 1, "Yosefh123", "Yosef huynh123", "yosefhuynh@knights.ucf.edu", "iambob123!!!", 4071231234);
    UsersTestData(1, 0, "KimG", "Gretchen Kim", "gretchenkim@knights.ucf.edu", "81ilovecates", 4072342345);
    UsersTestData(1, 0, "yann3Jac0b", "Cheyanne Jacobson", "cheyannejacobson@knights.ucf.edu", "1993wasdum", 3061231234);
    UsersTestData(1, 0, "Lamar Moss", "Lamar Moss", "lamarmoss@knights.ucf.edu", "yeswelovec@ts", 3062342345);
    UsersTestData(1, 1, "Aubree Travis", "Aubree Travis", "aubreetravis@knights.ucf.edu", "B0BwasHer3", 4073453456);
    UsersTestData(1, 0, "Lainey Mitchell", "Lainey Mitchell", "laineymitchell@fsu.edu", "WakeBoa2rding", 4074564567);
    UsersTestData(1, 0, "zz100", "Zoie Zimmerman", "zoiezimmerman@fsu.edu", "IloveC@ts", 3063453456);
    UsersTestData(1, 0, "Daws0n200", "Caroline Dawson", "carolinedawson@fsu.edu", "gottem2022!!", 3064564567);
    UsersTestData(1, 0, "PenaX", "Axel Pena", "axelpena@fsu.edu", "33saintJo0hn", 4075675678);
    UsersTestData(1, 0, "enam53", "Wyatt Pena", "wyattpena@knights.ucf.edu", "y@yford@ddys", 4076786789);
    UsersTestData(2, 0, "Darnell Vega", "Darnell Vega", "darnellvega", "yeswe@tit", 3065675678);
    UsersTestData(2, 0, "Coperlin", "Isaias Copeland", "isaiascopeland@knights.ucf.edu", "g@showabouth0rse", 3066786789);
    UsersTestData(2, 0, "Calderon0", "Janelle Calderon", "janellecalderon@knights.ucf.edu", "373737welove37@", 4077897890);
    UsersTestData(2, 0, "Nathanial675", "Nathanial Ibarra", "nathanialibarra@knights.ucf.edu", "@!$#@gotothegym", 4070980987);
    UsersTestData(2, 0, "Colby123", "Colby Watkins", "colbywatkins@fsu.edu", "y0g0p0g0eats0met0ma", 3067897890);
    UsersTestData(2, 0, "KristenPJ", "Kristen Pierce", "kristenpierce@fsu.edu", "easterbunny100", 3060980987);
    UsersTestData(2, 0, "EdithW987", "Edith Weiss", "edithweiss@fsu.edu", "s@nta!&%^", 4079879876);
    UsersTestData(2, 0, "JB3ltran", "Jovanni Beltran", "jovannibeltran@fsu.edu", "badbUNNy123", 4078768765);
    UsersTestData(2, 0, "BryantWWW76543", "Bryant Weeks", "bryantweeks@knights.ucf.edu", "welovedads", 3069879876);
    UsersTestData(2, 0, "KaleM", "Kael Murillo", "kaelmurillo@knights.ucf.edu", "stophatingm@n", 3068768765);
    UsersTestData(1, 0, "kenny", "Kenny", "kenny@knights.ucf.edu", "password", 3060909888);
    UsersTestData(1, 1, "kennySuper", "Kenny", "kennySuper@knights.ucf.edu", "password", 3060909888);
    UsersTestData(1, 0, "Travis", "Travis Wise", "Travis@knights.ucf.edu", "password", 3864795030);
    UsersTestData(1, 1, "TravisSuper", "Travis Wise", "Travis@knights.ucf.edu", "password", 3864795030);

    function RSOTestData($UniversityID, $OwnerID, $Name) 
    {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO RSO (UniversityID, OwnerID, Name) VALUES (?, ?, ?);";
        $stmt = $conn->prepare($sql);
        
        $Name_enc = encryptthis($Name, $key);
        $stmt->bind_param("iis", $UniversityID, $OwnerID, $Name_enc);
        $stmt->execute();

    }

    RSOTestData(1, 1, "Scratch Systems");
    RSOTestData(1, 2, "Main Python Services");
    RSOTestData(2, 5, "Wire Industries");
    RSOTestData(1, 23, "Travis's RSO");

    function RegisteredTestData($RSOID, $UserID)
    {
        $conn = connectToDatabase();
        $sql = "INSERT INTO Registered (RSOID, UserID) VALUES (?, ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $RSOID, $UserID);
        $stmt->execute();

        updateRSOStatus($RSOID);
    }

    RegisteredTestData(1, 1);
    RegisteredTestData(1, 2);
    RegisteredTestData(1, 3);
    RegisteredTestData(1, 4);
    RegisteredTestData(1, 5);
    RegisteredTestData(2, 6);
    RegisteredTestData(2, 7);
    RegisteredTestData(2, 8);
    RegisteredTestData(2, 9);
    RegisteredTestData(2, 10);
    RegisteredTestData(3, 11);
    RegisteredTestData(3, 12);
    RegisteredTestData(3, 13);
    RegisteredTestData(3, 14);
    RegisteredTestData(4, 20);
    RegisteredTestData(4, 21);
    RegisteredTestData(4, 22);
    RegisteredTestData(4, 23);
    
    function LocationTestData($Name, $Longitude, $Latitude, $Description)
    {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO Location (Name, Longitude, Latitude, Description) VALUES (?, ?, ?, ?);";
        $stmt = $conn->prepare($sql);
        
        $Name_enc = encryptthis($Name, $key);
        $Description_enc = encryptthis($Description, $key);

        $stmt->bind_param("siis", $Name_enc, $Longitude, $Latitude, $Description_enc);
        $stmt->execute();
    }

    LocationTestData("UCF Swimming Pool", 543467, -19803, "UCF Swimming Pool Wednesdays at 1PM!", );
    LocationTestData("UCF HEC Building", 16432, 34526, "Tonight at Room 119 in the HEC Building!", );
    LocationTestData("Business Building", 234567, 2366543, "Room 202 at 9PM on May 20th!", );
    LocationTestData("Starbucks Near School", -45845, 345364, "Starbucks at 9AM!", );
    LocationTestData("Chick-Fil-A Near School", 225446, 65453, "Chick-Fil-A at 10AM!", );


    function CategoriesTestData($Name)
    {
        $conn = connectToDatabase();
        $sql = "INSERT INTO Categories (Name) VALUES (?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $Name);
        $stmt->execute();
    }

    CategoriesTestData("Social");
    CategoriesTestData("Fundraising");
    CategoriesTestData("Tech Talks");
    CategoriesTestData("Swimming");
    CategoriesTestData("Food");
    CategoriesTestData("Protest");
    CategoriesTestData("Culture");
    CategoriesTestData("Fitness");
    CategoriesTestData("Party");
    CategoriesTestData("Movies");
    CategoriesTestData("Beach");
    CategoriesTestData("Springs");
    CategoriesTestData("Concert");
    CategoriesTestData("Programming");
    CategoriesTestData("Engineering");

    function ChatroomCommentsTestData($UserID, $Comment) {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO ChatroomComments (UserID, Comment) VALUES (?, ?);";
        $stmt = $conn->prepare($sql);

        $Comment_enc = encryptthis($Comment, $key);

        $stmt->bind_param("is", $UserID, $Comment_enc);
        $stmt->execute();
    }

    ChatroomCommentsTestData(23, "YOOOO!!!!");
    ChatroomCommentsTestData(21, "YO!!!! WHAT'S UP TRAVIS!");
    ChatroomCommentsTestData(23, "Sup kenny!");
    ChatroomCommentsTestData(19, "Any cool events going on?");
    ChatroomCommentsTestData(15, "Join Travis's RSO, it's pretty nice!!!");
    ChatroomCommentsTestData(12, "YO! Travis is a beast!");
    ChatroomCommentsTestData(21, "Yeah we love Travis here!");

    function EventsTestData($LocationID, $EventCat, $ForeignID, $Name, $Description, $Privacy, $ContactPhone, $ContactEmail, $Time)
    {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO Events (LocationID, EventCat, ForeignID, Name, Description, Privacy, ContactPhone, ContactEmail, Time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $conn->prepare($sql);

        $Name_enc = encryptthis($Name, $key);
        $Description_enc = encryptthis($Description, $key);
        $ContactPhone_enc = encryptthis($ContactPhone, $key);
        $ContactEmail_enc = encryptthis($ContactEmail, $key);

        $stmt->bind_param("iiississs", 
            $LocationID, 
            $EventCat, 
            $ForeignID, 
            $Name_enc, 
            $Description_enc, 
            $Privacy, 
            $ContactPhone_enc, 
            $ContactEmail_enc, 
            $Time);
        $stmt->execute();
    }

    EventsTestData(1,1,1,"Swim With Tim!","Get the chance to swim with Tim Tebow!", 1, 4077778888, "timtebow@gmail.com", "11:11:00");
    EventsTestData(2,7,1,"Happy Feat!","We will go watch a penguin movie!", 0, 4076664444, "yaya@gmail.com", "22:22:00");
    EventsTestData(3,12,2,"Robo Mobo!","We will work together to build a robot!", 2, 4073332222, "penquin@gmail.com", "3:33:00");
    EventsTestData(4,11,1,"C++ Sesh!","Let's learn C++!", 0, 4072229999, "rick@gmail.com", "44:44:00");
    EventsTestData(5,5,2,"Gym Rat!","Let's learn some new gym moves!", 2, 4071110000, "jock@gmail.com", "55:55:00");
   


   

   




    



    

    
    header("location: ../tools.php");