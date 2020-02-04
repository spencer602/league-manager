<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>

<?php
require 'header.php';

echo "<body>";
echo "<script>setTitle('Current Standings')</script>";
echo "<script>setCurrentPage('Current Standings')</script>";

include_once 'calculatescore.php';
include_once 'player.php';
include_once 'sqlscripts.php';

$seasonID = 2;

$allIDs = queryDB("SELECT player_id from registrations WHERE season_id = $seasonID");
$allPlayerData = array();

while ($row = $allIDs->fetch_assoc()) {
    $playerID = $row['player_id'];
    $playerData = getDataForPlayerID($playerID, $seasonID);
    array_push($allPlayerData, $playerData);
}

usort($allPlayerData, "sortByPoints");
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

function sortByPoints($a, $b) {
    if ($a->points == $b->points){
        if ($a->getWinPercentage() == $b->getWinPercentage()) {
            return 0;
        }
        return ($a->getWinPercentage() < $b->getWinPercentage()) ? 1 : -1;
    }
    return ($a->points < $b->points) ? 1 : -1;
}

echo "</table>";?>	

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
    </body>
</div>

</html>