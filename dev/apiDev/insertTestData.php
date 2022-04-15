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

    function RegisteredTestData($RSOID, $UserID)
    {
        $conn = connectToDatabase();
        $sql = "INSERT INTO Registered (RSOID, UserID) VALUES (?, ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $RSOID, $UserID);
        $stmt->execute();
    }

    function LocationTestData($Name, $Longitude, $Latitude, $Description)
    {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO Location (Name, Longitude, Latitude, Description) VALUES (?, ?, ?, ?);";
        $stmt = $conn->prepare($sql);
        
        $Name_enc = encryptthis($Name, $key);
        $Longitude_enc = encryptthis($Longitude, $key);
        $Latitude_enc = encryptthis($Latitude, $key);
        $Description_enc = encryptthis($Description, $key);

        $stmt->bind_param("siis", $Name_enc, $Longitude_enc, $Latitude_enc, $Description_enc);
        $stmt->execute();
    }

    function CategoriesTestData($Name)
    {
        $conn = connectToDatabase();
        $sql = "INSERT INTO Categories (Name) VALUES (?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $Name);
        $stmt->execute();
    }

    function EventsTestData($LocationID, $EventCat, $ForeignID, $Name, $Description, $Privacy, $ContactPhone, $ContactEmail)
    {
        $key = encryptionKey();
        $conn = connectToDatabase();
        $sql = "INSERT INTO Events (LocationID, EventCat, ForeignID, Name, Description, Privacy, ContactPhone, ContactEmail) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $conn->prepare($sql);

        $Name_enc = encryptthis($Name, $key);
        $Description_enc = encryptthis($Description, $key);
        $ContactPhone_enc = encryptthis($ContactPhone, $key);
        $ContactEmail_enc = encryptthis($ContactEmail, $key);

        $stmt->bind_param("iiississ", $LocationID, $EventCat, $ForeignID, $Name_enc, $Description_enc, $Privacy, $ContactPhone_enc, $ContactEmail_enc);
        $stmt->execute();
    }

    // UniversityTestData("University of Central Florida", "@UCF.edu");
    // UniversityTestData("Florida State University", "@FSU.edu");
    // UniversityTestData("Johns Hopkins University", "@JHU.edu");
    // UniversityTestData("Harvard University", "@HU.edu");
    // UniversityTestData("Yale University", "@YU.edu");
    // UniversityTestData("Sanford University", "@SU.edu");
    // UniversityTestData("Rice University", "@RU.edu");
    // UniversityTestData("Duke University", "@DU.edu");
    // UniversityTestData("Columbia University, "@CU.edu");
    // UniversityTestData("Princeton University", "@PU.edu");
    
    // UsersTestData(1, 1, "Yosef Huynh", "yosefhuynh", "password1", 4071231234);
    // UsersTestData(1, 0, "Gretchen Kim", "gretchenkim", "password2", 4072342345);
    // UsersTestData(1, 0, "Cheyanne Jacobson", "cheyannejacobson", "password3", 3061231234);
    // UsersTestData(1, 0, "Lamar Moss", "lamarmoss", "password4", 3062342345);
    // UsersTestData(1, 1, "Aubree Travis", "aubreetravis", "password5", 4073453456);
    // UsersTestData(2, 0, "Lainey Mitchell", "laineymitchell", "password6", 4074564567);
    // UsersTestData(2, 0, "Zoie Zimmerman", "zoiezimmerman", "password7", 3063453456);
    // UsersTestData(2, 0, "Caroline Dawson", "carolinedawson", "password8", 3064564567);
    // UsersTestData(3, 0, "Axel Pena", "axelpena", "password9", 4075675678);
    // UsersTestData(1, 0, "Wyatt Pena", "wyattpena", "password10", 4076786789);
    // UsersTestData(2, 0, "Darnell Vega", "darnellvega", "password11", 3065675678);
    // UsersTestData(3, 0, "Isaias Copeland", "isaiascopeland", "password12", 3066786789);
    // UsersTestData(4, 0, "Janelle Calderon", "janellecalderon", "password13", 4077897890);
    // UsersTestData(1, 0, "Nathanial Ibarra", "nathanialibarra", "password14", 4070980987);
    // UsersTestData(4, 0, "Colby Watkins", "colbywatkins", "password15", 3067897890);
    // UsersTestData(4, 0, "Kristen Pierce", "kristenpierce", "password16", 3060980987);
    // UsersTestData(1, 0, "Edith Weiss", "edithweiss", "password17", 4079879876);
    // UsersTestData(5, 0, "Jovanni Beltran", "jovannibeltran", "password18", 4078768765);
    // UsersTestData(5, 0, "Bryant Weeks", "bryantweeks", "password19", 3069879876);
    // UsersTestData(5, 0, "Kael Murillo", "kaelmurillo", "password20", 3068768765);
    // UsersTestData(6, 0, "Quintin Stokes", "quintinstokes", "password21", 4077657654);
    // UsersTestData(6, 0, "Damon Moran", "damonmoran", "password22", 4076546543);
    // UsersTestData(6, 0, "Viviana Vazquez", "vivianavazquez", "password23", 3067657654);
    // UsersTestData(1, 0, "Alison Santana", "alisonsantana", "password24", 3066546543);
    // UsersTestData(7, 0, "Oliver Colon", "olivercolon", "password25", 4075435432);
    // UsersTestData(7, 0, "Ariana Ball", "arianaball", "password26", 4074324321);
    // UsersTestData(7, 0, "Jakobe Bolton", "jakobebolton", "password27", 3065435432);
    // UsersTestData(1, 0, "Blake Winters", "blakewinters", "password28", 3064324321);
    // UsersTestData(8, 0, "Genesis Berger", "genesisberger", "password29", 4071980066);
    // UsersTestData(8, 0, "Ashton Ellison", "ashtonellison", "password30", 4076662344);
    // UsersTestData(1, 0, "Leia Finley", "leiafinley", "password31", 3061980066);
    // UsersTestData(8, 0, "Aaden Wang", "aadenwang", "password32", 3066662344);
    // UsersTestData(9, 0, "Zoey Hampton", "zoeyhampton", "password33", 4078889999);
    // UsersTestData(1, 0, "Elsie Alvarado", "elsiealvarado", "password34", 4075677777);
    // UsersTestData(9, 0, "Anika Francis", "anikafrancis", "password35", 3068889999);
    // UsersTestData(2, 0, "UCF_User1", "UCF_User1@gmail.com", "UCF_User1", 3065677777);
    // UsersTestData(2, 0, "UCF_User2", "UCF_User2@gmail.com", "UCF_User2", 4072564658);
    // UsersTestData(2, 0, "UCF_User3", "UCF_User3@gmail.com", "UCF_User3", 4070909888);
    // UsersTestData(2, 0, "UCF_User4", "UCF_User4@gmail.com", "UCF_User4", 3062564658);
    // UsersTestData(2, 0, "UCF_User5", "UCF_User5@gmail.com", "UCF_User5", 3060909888);
    // UsersTestData(2, 0, "kenny", "kenny@knights.ucf.edu", "password", 3060909888);
    // UsersTestData(2, 0, "kenny", "kenny", "password", 3060909888);
    // UsersTestData(2, 0, "kenny", "kenny@knights.ucf.edu", "password", 3060909888);
    // UsersTestData(2, 1, "kennySuper", "kennySuper@knights.ucf.edu", "password", 3060909888);
    // UsersTestData(2, 0, "Travis", "Travis@knights.ucf.edu", "password", 3864795030);
    // UsersTestData(2, 1, "TravisSuper", "Travis@knights.ucf.edu", "password", 3864795030);
    
    // RSOTestData(1, 1, "Scratch Systems");
    // RSOTestData(1, 2, "Main Python Services");
    // RSOTestData(2, 5, "Wire Industries");
    // RSOTestData(2, 6, "Plug");
    // RSOTestData(3, 9, "Glow Worm Mix");
    // RSOTestData(3, 10, "New Watchtower");
    // RSOTestData(4, 13, "Sundial Inc");
    // RSOTestData(4, 14, "Redstart Systems");
    // RSOTestData(5, 17, "Industry Systems");
    // RSOTestData(5, 18, "Joy Inc");
    // RSOTestData(6, 21, "Three-Sixty Works");
    // RSOTestData(6, 22, "Running Crazy Jane Services");
    // RSOTestData(7, 25, "Oval Works");
    // RSOTestData(7, 26, "Strapper");
    // RSOTestData(8, 29, "Omega Technologies");
    // RSOTestData(8, 30, "Red Scramble Systems");
    // RSOTestData(9, 33, "Flying Magic Carpet Technolo");
    // RSOTestData(9, 34, "Hyacinth International");
    // RSOTestData(10, 37, "Ivo Inc");
    // RSOTestData(10, 38, "Mudcakes Flux");
    
    // RegisteredTestData(1, 3);
    // RegisteredTestData(2, 4);
    // RegisteredTestData(3, 7);
    // RegisteredTestData(4, 8);
    // RegisteredTestData(5, 11);
    // RegisteredTestData(6, 12);
    // RegisteredTestData(7, 15);
    // RegisteredTestData(8, 16);
    // RegisteredTestData(9, 19);
    // RegisteredTestData(10, 20);
    // RegisteredTestData(11, 23);
    // RegisteredTestData(12, 24);
    // RegisteredTestData(13, 27);
    // RegisteredTestData(14, 28);
    // RegisteredTestData(15, 31);
    // RegisteredTestData(16, 32);
    // RegisteredTestData(17, 35);
    // RegisteredTestData(18, 36);
    // RegisteredTestData(19, 39);
    // RegisteredTestData(20, 40);
    
    // LocationTestData("UCF Swimming Pool", 0, 0, "UCF Swimming Pool Wednesdays at 1PM!");
    // LocationTestData("UCF HEC Building", 0, 0, "Tonight at Room 119 in the HEC Building!");
    // LocationTestData("Business Building", 0, 0, "Room 202 at 9PM on May 20th!");
    // LocationTestData("Starbucks Near School", 0, 0, "Starbucks at 9AM!");
    // LocationTestData("Chick-Fil-A Near School", 0, 0, "Chick-Fil-A at 10AM!");
    // LocationTestData("Chilli's Near School", 0, 0, "Chilli's at 11AM!");
    // LocationTestData("Starbucks Near School", 0, 0, "Starbucks at 12AM!");
    // LocationTestData("Chick-Fil-A Near School", 0, 0, "Chick-Fil-A at 1PM!");
    // LocationTestData("Starbucks Near School", 0, 0, "Starbucks at 2PM!");
    // LocationTestData("Chilli's Near School", 0, 0, "Chilli's at 3PM!");
    
    // CategoriesTestData("Social");
    // CategoriesTestData("Fundraising");
    // CategoriesTestData("Tech Talks");
    // CategoriesTestData("Swimming");
    // CategoriesTestData("Food");
    // CategoriesTestData("Protest");
    // CategoriesTestData("Culture");
    // CategoriesTestData("Fitness");
    // CategoriesTestData("Party");
    // CategoriesTestData("Movies");
    // CategoriesTestData("Beach");
    // CategoriesTestData("Springs");
    // CategoriesTestData("Concert");
    // CategoriesTestData("Programming");
    // CategoriesTestData("Engineering");
    
    // EventsTestData(1,1,1,"Swim With Tim!","Get the chance to swim with Tim Tebow!", 1, 4077778888, "timtebow@gmail.com");
    // EventsTestData(2,7,1,"Happy Feat!","We will go watch a penguin movie!", 0, 4076664444, "yaya@gmail.com");
    // EventsTestData(3,12,1,"Robo Mobo!","We will work together to build a robot!", 1, 4073332222, "penquin@gmail.com");
    // EventsTestData(4,11,1,"C++ Sesh!","Let's learn C++!", 0, 4072229999, "rick@gmail.com");
    // EventsTestData(5,5,1,"Gym Rat!","Let's learn some new gym moves!", 1, 4071110000, "jock@gmail.com");
    // EventsTestData(6,10,20,"Lil Nas X!","Let's all join the concert!", 2, 4071113333, "nasx@gmail.com");
    // EventsTestData(7,6,1,"Party at Marty's!","Marty's birthday at his house!", 0, 4079993333, "marty@gmail.com");
    // EventsTestData(8,9,18,"Rock!","Let's go to Rock Springs!", 1, 4071233426, "rocky@gmail.com");
    // EventsTestData(9,4,13,"Middle East!","Let's try some awesome food!", 2, 4074970924, "middleeast@gmail.com");
    // EventsTestData(10,3,19,"Protest at NY!","Let's protest for equal rights at NY!", 1, 4079845555, "protest@gmail.com");

    /*
    UsersTestData(1, 1, "Yosef huynh123", "yosefhuynh@knights.ucf.edu", "iambob123!!!", 4071231234);
    UsersTestData(1, 0, "Gretchen Kim", "gretchenkim@knights.ucf.edu", "81ilovecates", 4072342345);
    UsersTestData(1, 0, "Cheyanne Jacobson", "cheyannejacobson@knights.ucf.edu", "1993wasdum", 3061231234);
    UsersTestData(1, 0, "Lamar Moss", "lamarmoss@knights.ucf.edu", "yeswelovec@ts", 3062342345);
    UsersTestData(1, 1, "Aubree Travis", "aubreetravis@knights.ucf.edu", "B0BwasHer3", 4073453456);
    UsersTestData(2, 0, "Lainey Mitchell", "laineymitchell@fsu.edu", "WakeBoa2rding", 4074564567);
    UsersTestData(2, 0, "Zoie Zimmerman", "zoiezimmerman@fsu.edu", "IloveC@ts", 3063453456);
    UsersTestData(2, 0, "Caroline Dawson", "carolinedawson@fsu.edu", "gottem2022!!", 3064564567);
    UsersTestData(2, 0, "Axel Pena", "axelpena@fsu.edu", "33saintJo0hn", 4075675678);
    UsersTestData(1, 0, "Wyatt Pena", "wyattpena@knights.ucf.edu", "y@yford@ddys", 4076786789);
    UsersTestData(2, 0, "Darnell Vega", "darnellvega", "yeswe@tit", 3065675678);
    UsersTestData(1, 0, "Isaias Copeland", "isaiascopeland@knights.ucf.edu", "g@showabouth0rse", 3066786789);
    UsersTestData(1, 0, "Janelle Calderon", "janellecalderon@knights.ucf.edu", "373737welove37@", 4077897890);
    UsersTestData(1, 0, "Nathanial Ibarra", "nathanialibarra@knights.ucf.edu", "@!$#@gotothegym", 4070980987);
    UsersTestData(2, 0, "Colby Watkins", "colbywatkins@fsu.edu", "y0g0p0g0eats0met0ma", 3067897890);
    UsersTestData(2, 0, "Kristen Pierce", "kristenpierce@fsu.edu", "easterbunny100", 3060980987);
    UsersTestData(2, 0, "Edith Weiss", "edithweiss@fsu.edu", "s@nta!&%^", 4079879876);
    UsersTestData(2, 0, "Jovanni Beltran", "jovannibeltran@fsu.edu", "badbUNNy123", 4078768765);
    UsersTestData(1, 0, "Bryant Weeks", "bryantweeks@knights.ucf.edu", "welovedads", 3069879876);
    UsersTestData(1, 0, "Kael Murillo", "kaelmurillo@knights.ucf.edu", "stophatingm@n", 3068768765);
    */ 


   
    UniversityTestData("University of Central Florida", "@knights.ucf.edu");
    UniversityTestData("Florida State University", "@fsu.edu");

    UsersTestData(1, 1, "Yosefh123", "Yosef huynh123", "yosefhuynh@knights.ucf.edu", "iambob123!!!", 4071231234);
    UsersTestData(1, 0, "KimG", "Gretchen Kim", "gretchenkim@knights.ucf.edu", "81ilovecates", 4072342345);
    UsersTestData(1, 0, "yann3Jac0b", "Cheyanne Jacobson", "cheyannejacobson@knights.ucf.edu", "1993wasdum", 3061231234);
    UsersTestData(1, 0, "Lamar Moss", "Lamar Moss", "lamarmoss@knights.ucf.edu", "yeswelovec@ts", 3062342345);
    UsersTestData(1, 1, "Aubree Travis", "Aubree Travis", "aubreetravis@knights.ucf.edu", "B0BwasHer3", 4073453456);
    UsersTestData(2, 0, "Lainey Mitchell", "Lainey Mitchell", "laineymitchell@fsu.edu", "WakeBoa2rding", 4074564567);
    UsersTestData(2, 0, "zz100", "Zoie Zimmerman", "zoiezimmerman@fsu.edu", "IloveC@ts", 3063453456);
    UsersTestData(2, 0, "Daws0n200", "Caroline Dawson", "carolinedawson@fsu.edu", "gottem2022!!", 3064564567);
    UsersTestData(2, 0, "PenaX", "Axel Pena", "axelpena@fsu.edu", "33saintJo0hn", 4075675678);
    UsersTestData(1, 0, "enam53", "Wyatt Pena", "wyattpena@knights.ucf.edu", "y@yford@ddys", 4076786789);
    UsersTestData(2, 0, "Darnell Vega", "Darnell Vega", "darnellvega", "yeswe@tit", 3065675678);
    UsersTestData(1, 0, "Coperlin", "Isaias Copeland", "isaiascopeland@knights.ucf.edu", "g@showabouth0rse", 3066786789);
    UsersTestData(1, 0, "Calderon0", "Janelle Calderon", "janellecalderon@knights.ucf.edu", "373737welove37@", 4077897890);
    UsersTestData(1, 0, "Nathanial675", "Nathanial Ibarra", "nathanialibarra@knights.ucf.edu", "@!$#@gotothegym", 4070980987);
    UsersTestData(2, 0, "Colby123", "Colby Watkins", "colbywatkins@fsu.edu", "y0g0p0g0eats0met0ma", 3067897890);
    UsersTestData(2, 0, "KristenPJ", "Kristen Pierce", "kristenpierce@fsu.edu", "easterbunny100", 3060980987);
    UsersTestData(2, 0, "EdithW987", "Edith Weiss", "edithweiss@fsu.edu", "s@nta!&%^", 4079879876);
    UsersTestData(2, 0, "JB3ltran", "Jovanni Beltran", "jovannibeltran@fsu.edu", "badbUNNy123", 4078768765);
    UsersTestData(1, 0, "BryantWWW76543", "Bryant Weeks", "bryantweeks@knights.ucf.edu", "welovedads", 3069879876);
    UsersTestData(1, 0, "KaleM", "Kael Murillo", "kaelmurillo@knights.ucf.edu", "stophatingm@n", 3068768765);

    RSOTestData(1, 1, "Scratch Systems");
    RSOTestData(1, 2, "Main Python Services");
    RSOTestData(2, 5, "Wire Industries");

    RegisteredTestData(1, 3);
    RegisteredTestData(1, 4);
    RegisteredTestData(1, 7);
    RegisteredTestData(1, 8);
    RegisteredTestData(1, 11);
    RegisteredTestData(2, 12);
    RegisteredTestData(2, 15);
    RegisteredTestData(2, 16);
    RegisteredTestData(2, 19);
    RegisteredTestData(2, 20);
    RegisteredTestData(3, 23);
    RegisteredTestData(3, 24);
    RegisteredTestData(3, 27);
    RegisteredTestData(3, 28);
    RegisteredTestData(3, 31);



    LocationTestData("UCF Swimming Pool", 0, 0, "UCF Swimming Pool Wednesdays at 1PM!");
    LocationTestData("UCF HEC Building", 0, 0, "Tonight at Room 119 in the HEC Building!");
    LocationTestData("Business Building", 0, 0, "Room 202 at 9PM on May 20th!");
    LocationTestData("Starbucks Near School", 0, 0, "Starbucks at 9AM!");
    LocationTestData("Chick-Fil-A Near School", 0, 0, "Chick-Fil-A at 10AM!");

    EventsTestData(1,1,1,"Swim With Tim!","Get the chance to swim with Tim Tebow!", 1, 4077778888, "timtebow@gmail.com");
    EventsTestData(2,7,1,"Happy Feat!","We will go watch a penguin movie!", 0, 4076664444, "yaya@gmail.com");
    EventsTestData(3,12,2,"Robo Mobo!","We will work together to build a robot!", 2, 4073332222, "penquin@gmail.com");
    EventsTestData(4,11,1,"C++ Sesh!","Let's learn C++!", 0, 4072229999, "rick@gmail.com");
    EventsTestData(5,5,2,"Gym Rat!","Let's learn some new gym moves!", 2, 4071110000, "jock@gmail.com");
    
    header("location: ../tools.php");