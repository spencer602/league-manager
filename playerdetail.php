<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>
    <link rel="stylesheet" href="css/matchhistory.css">

<?php
require 'header.php';

echo "<body>";
echo "<script>setTitle('Player Detail')</script>";
echo "<script>setCurrentPage('Player Detail')</script>";
?>
    <br>

<?php
include_once "LeagueManager.php";

$leagueManager = new LeagueManager();
$leagueManager->updateForSeason(2);

$playerID = $_GET['id'];

$player = $leagueManager->getPlayerWithID($playerID);
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

$matches = $leagueManager::getAllMatchesFor(2, $playerID, null);

guidisplayAllMatches($matches);

echo '<br><hr><br>';

?>

    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>