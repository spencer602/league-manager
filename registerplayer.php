<?php


session_start();

if ($_SESSION['adminLoggedIn'] != 1) {
    header("location: adminloginform.php");
}


include_once 'sqlscripts.php';

// gathers the data from the form
$formPName = $_POST["player"];
$adminPassword = $_POST["adminPassword"];
$playerPassword = $_POST["playerPassword"];
$confirmPlayerPassword = $_POST["confirmPlayerPassword"];

if ($playerPassword != $confirmPlayerPassword) { die("Player Passwords do not match"); }

$hash = password_hash($playerPassword, PASSWORD_DEFAULT);

// queries the player table

$player = queryDB("SELECT player_id FROM players WHERE player_name = '$formPName'");
$playerData = $player->fetch_array(MYSQLI_ASSOC);
$playerID = $playerData['player_id'];



// the query we are using for inserting the match into the table
$queryString = "UPDATE players SET password = '$hash' WHERE player_id = $playerID;";



// send the query to the database
queryDB($queryString);
$seasonID = 2;

$queryString = "INSERT INTO registrations (season_id, player_id, paid) VALUES ($seasonID, $playerID, 0)";
queryDB($queryString);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register A Player</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/registered.css">
</head>
<div id="wrapper">
    <body>
    <div id ="header">
        <a href="index.php"><img src="images/logo.jpg" id="logo"></a>
        <div id="pageName">
            <h1>Big Sky</h1><br>
            <h1>Shark Hunt</h1><br>
            <h1>Match Form</h1>
        </div>
    </div>
    <div id="nav">
        <ul id="navbar">
            <li><a href = "registermatchform.php">Register</a><br></li>
            <li><a href = "displayallmatches.php">History</a><br></li>
            <li><a href = "index.php">Standings</a></li>
        </ul>
    </div>
    <p id="content">Thank you for registering the player!</p>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>