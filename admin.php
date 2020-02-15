<?php
session_start();

include_once 'LeagueManager.php';

$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register A Match</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/registermatchform.css">
</head>
<script src="registermatch2020.js"></script>
<script src="inputBoxChange.js"></script>
<div id="wrapper">
    <body onload="bodyLoaded()">
    <div id ="header">
        <a href="index.php"><img src="images/logo.jpg" id="logo"></a>
        <div id="pageName">
            <h1>Big Sky</h1><br>
            <h1>Shark Hunt</h1><br>
            <h1>Admin</h1>
        </div>
    </div>
    <div id="nav">
        <ul id="navbar">
            <li><a href = "registermatchform.php">Register</a><br></li>
            <li><a href = "displayallmatches.php">History</a><br></li>
            <li><a href = "index.php">Standings</a></li>
            <li><a href = "players.php">Players</a></li>

        </ul>
    </div>
    <br>
    <?php
    list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);

    if ($registerPlayer == 1) { echo "<a href = 'registerplayerform.php'>Register a Player for the current season</a><br><br>"; }
    if ($markPaid == 1) { echo "<a href = 'markplayerpaidform.php'>Mark a player as paid for the current season</a><br><br>"; }
    echo "<a href = 'playerwhohavenotpaid.php'>View the players who have not yet paid for the season</a><br><br>";
    if ($registerTourney == 1) { echo "<a href = 'registertournamentresultform.php'>Register tournament Results</a><br><br>"; }
    if ($registerTourney == 1) { echo "<a href = 'registertourneymatchform.php'>Register tournament match</a><br><br>"; }
    if ($addPlayer == 1) { echo "<a href = 'createnewplayerform.php'>Create a new player</a><br><br>"; }
    if ($validateMatch == 1) { echo "<a href = 'validatematchesform.php'>Validate Matches</a>"; }

    ?>

    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>