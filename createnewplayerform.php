<?php
session_start();

if ($_SESSION['adminLoggedIn'] != 1) {
    header("location: adminloginform.php");
}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a new Player</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/registermatchform.css">
</head>
<!--<script src="registermatch2020.js"></script>-->
<!--<script src="inputBoxChange.js"></script>-->
<div id="wrapper">
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
            <li><a href = "players.php">Players</a></li>

        </ul>
    </div><br><br>
    <div id="container">
        <form action = "createplayer.php" method = "post">


            <div id="passwords">
                <label id = "nameLabel">Player Name:</label><br>
                <input type = "text" name = "name" class = "input">
                <br><br>
                <label id = "phoneLabel">Phone Number:</label><br>
                <input type = "text" name = "phone" class = "input">
                <br><br>
                <label id = "rankLabel">Player Rank:</label><br>
                <input type = "text" name = "rank" class = "input">
                <br><br>
                <br>
            </div>
            <input type = "submit" id="subbut">
        </form>
        <br>
    </div>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>