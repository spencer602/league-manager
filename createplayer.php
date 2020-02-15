<?php
include_once 'LeagueManager.php';

session_start();
$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}
list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);
if ($addPlayer != 1) { header("location: adminloginform.php"); }


include_once 'sqlscripts.php';

$rank = $_POST['rank'];
$name = $_POST['name'];
$phone = $_POST['phone'];

if ($rank >= 1 && $rank <= 4) {
    queryDB("INSERT INTO players (player_name, phone, rank) VALUES ('$name', '$phone', $rank);");
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create A Player</title>
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
            <h1>Create Player</h1>
        </div>
    </div>
    <div id="nav">
        <ul id="navbar">
            <li><a href = "registermatchform.php">Register</a><br></li>
            <li><a href = "displayallmatches.php">History</a><br></li>
            <li><a href = "index.php">Standings</a></li>
        </ul>
    </div>
    <p id="content">Thank you for creating the player!</p>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>