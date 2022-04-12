<?php 
    include_once "api_functions.php";

    function signupTestData($UniversityID, $Super, $Name, $Gmail, $Password, $Phone) {
    $conn = connectToDatabase();
    $sql = "INSERT INTO Users(UniversityID, `Super`, `Name`, `Gmail`, `Phone`, `Password`) VALUES ($UniversityID, $Super, '$Name', '$Gmail', $Phone, '$Password');";
    $result = mysqli_query($conn, $sql);
    if (!$result)
        echo mysqli_error($conn);
    }
    
    signupTestData(1, 0, "Gretchen Kim", "gretchenkim", "password2", 4072342345);
    signupTestData(1, 1, "Yosef Huynh", "yosefhuynh", "password1", 4071231234);
    signupTestData(1, 0, "Cheyanne Jacobson", "cheyannejacobson", "password3", 3061231234);
    signupTestData(1, 0, "Lamar Moss", "lamarmoss", "password4", 3062342345);
    signupTestData(1, 1, "Aubree Travis", "aubreetravis", "password5", 4073453456);
    signupTestData(2, 0, "Lainey Mitchell", "laineymitchell", "password6", 4074564567);
    signupTestData(2, 0, "Zoie Zimmerman", "zoiezimmerman", "password7", 3063453456);
    signupTestData(2, 0, "Caroline Dawson", "carolinedawson", "password8", 3064564567);
    signupTestData(3, 0, "Axel Pena", "axelpena", "password9", 4075675678);
    signupTestData(1, 0, "Wyatt Pena", "wyattpena", "password10", 4076786789);
    signupTestData(2, 0, "Darnell Vega", "darnellvega", "password11", 3065675678);
    signupTestData(3, 0, "Isaias Copeland", "isaiascopeland", "password12", 3066786789);
    signupTestData(4, 0, "Janelle Calderon", "janellecalderon", "password13", 4077897890);
    signupTestData(1, 0, "Nathanial Ibarra", "nathanialibarra", "password14", 4070980987);
    signupTestData(4, 0, "Colby Watkins", "colbywatkins", "password15", 3067897890);
    signupTestData(4, 0, "Kristen Pierce", "kristenpierce", "password16", 3060980987);
    signupTestData(1, 0, "Edith Weiss", "edithweiss", "password17", 4079879876);
    signupTestData(5, 0, "Jovanni Beltran", "jovannibeltran", "password18", 4078768765);
    signupTestData(5, 0, "Bryant Weeks", "bryantweeks", "password19", 3069879876);
    signupTestData(5, 0, "Kael Murillo", "kaelmurillo", "password20", 3068768765);
    signupTestData(6, 0, "Quintin Stokes", "quintinstokes", "password21", 4077657654);
    signupTestData(6, 0, "Damon Moran", "damonmoran", "password22", 4076546543);
    signupTestData(6, 0, "Viviana Vazquez", "vivianavazquez", "password23", 3067657654);
    signupTestData(1, 0, "Alison Santana", "alisonsantana", "password24", 3066546543);
    signupTestData(7, 0, "Oliver Colon", "olivercolon", "password25", 4075435432);
    signupTestData(7, 0, "Ariana Ball", "arianaball", "password26", 4074324321);
    signupTestData(7, 0, "Jakobe Bolton", "jakobebolton", "password27", 3065435432);
    signupTestData(1, 0, "Blake Winters", "blakewinters", "password28", 3064324321);
    signupTestData(8, 0, "Genesis Berger", "genesisberger", "password29", 4071980066);
    signupTestData(8, 0, "Ashton Ellison", "ashtonellison", "password30", 4076662344);
    signupTestData(1, 0, "Leia Finley", "leiafinley", "password31", 3061980066);
    signupTestData(8, 0, "Aaden Wang", "aadenwang", "password32", 3066662344);
    signupTestData(9, 0, "Zoey Hampton", "zoeyhampton", "password33", 4078889999);
    signupTestData(1, 0, "Elsie Alvarado", "elsiealvarado", "password34", 4075677777);
    signupTestData(9, 0, "Anika Francis", "anikafrancis", "password35", 3068889999);
    signupTestData(2, 0, "yo1", "yo1@gmail.com", "password36", 3065677777);
    signupTestData(2, 0, "yo2", "yo2@gmail.com", "password37", 4072564658);
    signupTestData(2, 0, "yo3", "yo3@gmail.com", "password38", 4070909888);
    signupTestData(2, 0, "yo4", "yo4@gmail.com", "password39", 3062564658);
    signupTestData(2, 0, "yo5", "yo5@gmail.com", "password40", 3060909888);
    signupTestData(2, 0, "kenny", "kenny@ucf.edu", "password", 3060909888);