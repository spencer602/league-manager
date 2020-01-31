<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Player Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/matchhistory.css">
    <link rel="stylesheet" href="css/standings.css">

</head>

<div id="wrapper">
    <body>
    <div id="header">
        <div id ="logo">
            <a href="index.php"><img src="images/logo.jpg" id="logo"></a><br>
        </div>
        <div id="pageName">
            <h1>Big Sky</h1><br>
            <h1>Shark Hunt</h1><br>
            <h1>Player Detail</h1>
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
include_once "sqlscripts.php";
include_once "helperfunctions.php";
include_once "calculatescore.php";
include_once "LeagueManager.php";

$leagueManager = new LeagueManager();
$leagueManager->updateForSeason(2);

$playerID = $_GET['id'];

$player = getDataForPlayerID($playerID, 2);
$position = $leagueManager->getPositionForPlayerWithID($playerID);
$name = $player->name;
$points = $player->points + 250;
$rank = $player->rank;
$matchPercentage = $player->getMatchPercentage();
$gamePercentage = $player->getWinPercentage();
$gamesWon = $player->gamesWon;
$matchesWon = $player->matchesWon;
$gamesPlayed = $player->gamesPlayed;
$matchesPlayed = $player->matchesPlayed;
$eros = $player->eros;
$phoneNumber = $player->phoneNumber;

if ($matchPercentage != -1) {
    $matchPercentage = number_format((float)$matchPercentage, 1, '.', '');
} else {
    $matchPercentage = "NA";
}

if ($gamePercentage != -1) {
    $gamePercentage = number_format((float)$gamePercentage, 1, '.', '');
} else {
    $gamePercentage = "NA";
}

echo "<div class = 'firstRowOfCell'>$name</div>";
echo "<div>Place in Standings: $position</div>";
echo "<div>Points: $points</div>";
echo "<div>Skill Rank (1-4): $rank</div>";
echo "<div>Matches: $matchPercentage% ($matchesWon/$matchesPlayed)";
echo "<div>Games: $gamePercentage% ($gamesWon/$gamesPlayed)";
echo "<div>EROs: $eros";
echo "<div>Phone: $phoneNumber<br><br><hr><br>";
echo "<div class = 'firstRowOfCell'>Matches Played:</div>";


displayAllMatches(2, $playerID);

echo '<br><hr><br>';



?>

    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>