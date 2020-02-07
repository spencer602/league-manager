<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>

<?php
require 'header.php';

echo "<body>";
echo "<script>setTitle('Current Standings')</script>";
echo "<script>setCurrentPage('Current Standings')</script>";

echo '<br>';

//include_once 'calculatescore.php';
//include_once 'player.php';
//include_once 'sqlscripts.php';
include_once 'LeagueManager.php';

$seasonID = 2;

$leagueManager = new LeagueManager();
$leagueManager->updateForSeason($seasonID);
$allPlayerData = $leagueManager->getAllPlayerData();

usort($allPlayerData, "sortByPointsThenMatchPercentage");
$position = 0;

echo '<table id="standingsTable">';

for ($i = 0; $i < count($allPlayerData); $i++) {
    $position++;
    $playerData = $allPlayerData[$i];
    $playerID = $playerData->id;
    $points = $playerData->points + 250;
    $rank = $playerData->rank;
    $name = $playerData->name;
    $gamesWon = $playerData->gamesWon;
    $gamesPlayed = $playerData->gamesPlayed;
    $matchesWon = $playerData->matchesWon;
    $matchesPlayed = $playerData->matchesPlayed;
    $eros = $playerData->eros;
    $matchPercentage = $playerData->getMatchPercentage();
    $gamePercentage = $playerData->getWinPercentage();

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
    echo "<tr><td class = 'positionTD'><span class = 'positionSpan'>$position</span></td>
        <td><div class = 'firstRowOfCell'>$points <a class = 'playerhref' href = 'playerdetail.php?id=$playerID'>$name</a></div>
        <div class = 'secondRowOfCell'>Matches: $matchPercentage% ($matchesWon/$matchesPlayed)</div>
        <div class = 'thirdRowOfCell'>Games: $gamePercentage% ($gamesWon/$gamesPlayed) - ERO: $eros</div></td></tr>";
}

echo "</table>";?>	

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
    </body>
</div>

</html>