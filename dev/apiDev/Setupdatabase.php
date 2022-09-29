<?php 
    include_once "../../api/api_functions.php";
    $conn = new mysqli("localhost", "root", "");

    
    $sql = "CREATE DATABASE app;";
    mysqli_query($conn, $sql);

    $sql = "USE app;";
    mysqli_query($conn, $sql);

    $sql = "create user 'Admin' identified by 'HeighT#157s';";
    mysqli_query($conn, $sql);

    $sql = "grant all privileges on App.* to 'Admin'";
mysqli_query($conn, $sql);

$sql = "'%';";
    mysqli_query($conn, $sql);

    $sql = "use app;";
    mysqli_query($conn, $sql);
    $conn = connectToDatabase();

    $sql = "CREATE TABLE `University` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `Name` varchar(255) NOT NULL,
      `Bio` varchar(255),
      `GmailAt` varchar(255) NOT NULL,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Users` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `UniversityID` int NOT NULL REFERENCES University(ID),
    CONSTRAINT FK_User_Unvi FOREIGN KEY (UniversityID) REFERENCES University(ID),
      `Super` boolean NOT NULL DEFAULT  0,
      `Username` varchar(255) NOT NULL,
      `Name` varchar(255)  NOT NULL,
      `Gmail` varchar(255) NOT NULL,
      `Phone` varchar(255),
      `Password` varchar(255),
      `ColorPreferences` varchar(255) NOT NULL DEFAULT 0,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`UniversityID`) REFERENCES `University`(`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `RSO` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `UniversityID` int NOT NULL REFERENCES University(ID),
      `OwnerID` int NOT NULL REFERENCES Users(ID),
      `Status` boolean NOT NULL DEFAULT 0,
      `Name` varchar(255) NOT NULL,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`UniversityID`) REFERENCES `University`(`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Registered` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `RSOID` int NOT NULL REFERENCES Users(ID),
      `UserID` int NOT NULL REFERENCES Users(ID),
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`UserID`) REFERENCES `Users`(`ID`),
      FOREIGN KEY (`RSOID`) REFERENCES `RSO`(`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Location` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `Name` varchar(255) NOT NULL DEFAULT '',
      `Description` text,
      `Longitude` int NOT NULL DEFAULT 0,
      `Latitude` int NOT NULL DEFAULT 0,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Categories` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `Name` varchar(255) NOT NULL,
      PRIMARY KEY (`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Events` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `LocationID` int NOT NULL REFERENCES Location(ID),
      `EventCat` int NOT NULL REFERENCES Categories(ID),
      `ForeignID` int,
    CONSTRAINT FK_Events_Loc FOREIGN KEY (LocationID) REFERENCES Location(ID),
    CONSTRAINT FK_Events_Eve FOREIGN KEY (EventCat) REFERENCES Categories(ID),
      `Time` time,
      `Name` varchar(255) NOT NULL DEFAULT '',
      `Description` varchar(255) NOT NULL DEFAULT '',
      `Privacy` int NOT NULL DEFAULT 0,
      `ContactPhone` varchar(255) NOT NULL,
      `ContactEmail` varchar(255) NOT NULL,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`LocationID`) REFERENCES `Location`(`ID`),
      FOREIGN KEY (`EventCat`) REFERENCES `Categories`(`ID`),
      FOREIGN KEY (`ForeignID`) REFERENCES `RSO`(`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Ratings` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `EventID` int NOT NULL REFERENCES Events(ID),
      `UserID` int NOT NULL REFERENCES Users(ID),
    CONSTRAINT FK_Rat_Eve FOREIGN KEY (EventID) REFERENCES Events(ID),
    CONSTRAINT FK_Rat_User FOREIGN KEY (UserID) REFERENCES Users(ID),
      `Rating` int,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`UserID`) REFERENCES `Users`(`ID`),
      FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventCat`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `Comments` (
      `ID` Int NOT NULL AUTO_INCREMENT,
      `EventID` int NOT NULL REFERENCES Events(ID),
      `UserID` int NOT NULL REFERENCES Users(ID),
    CONSTRAINT FK_Com_Eve FOREIGN KEY (EventID) REFERENCES Events(ID),
    CONSTRAINT FK_Com_User FOREIGN KEY (UserID) REFERENCES Users(ID),
      `Text` text,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`EventID`) REFERENCES `Events`(`EventCat`),
      FOREIGN KEY (`UserID`) REFERENCES `Users`(`ID`)
    );";
mysqli_query($conn, $sql);

    $sql ="CREATE TABLE `ChatroomComments` (
      `ID` int NOT NULL AUTO_INCREMENT,
      `UserID` int NOT NULL REFERENCES Users(ID),
      `Comment` text NOT NULL,
      `DataTimeCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `DataTimeUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`UserID`) REFERENCES `Users`(`ID`)
    );";

    mysqli_query($conn, $sql);


    header("location: ../tools.php");

    ?>