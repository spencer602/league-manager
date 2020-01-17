<?php
include 'calculatescore.php';

function allDataAllPlayers() {
    $dbhost  = 'localhost';

    $dbname  = 'sharkhunt';   // Modify these...
    $dbuser  = 'spencer';   // ...variables according
    $dbpass  = 'salute';   // ...to your installation

    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($connection->connect_error)
        die("Fatal Error 1");
    $allStandings = mysqli_query($connection, "SELECT * from players ORDER BY points");

    $allPlayers = array();

// position is the players position in the rankings
    $position = 0;
//    echo '<table id="standingsTable">';
    while ($row = $allStandings->fetch_assoc()) {
        $name = $row['player_name'];
        $playerData = getDataForPlayerID($row['player_id']);
        $oldPoints = $row['points'];
        $points = 250 + $playerData[0];

        $playerRow = array($name, $row['player_id'], $points, $playerData[1], $playerData[2], $playerData[3], $playerData[4], $playerData[5]);
        array_push($allPlayers, $playerRow);

        $wp = $playerData[1]/$playerData[2];

        echo "$name: Points: $points, Matches: ($wp) $playerData[1]/$playerData[2], Games: $playerData[3]/$playerData[4], ERO: $playerData[5] <br>";

    }
    return $allPlayers;
}

$alldata = allDataAllPlayers();

usort($alldata, "sortByWinPercentage");

for ($i = 0; $i < count($alldata); $i++) {
    $thisRow = $alldata[$i];
    $name = $thisRow[0];
    $wp = $thisRow[5]/$thisRow[6];
    $gamesPlayed = $thisRow[6];

    $wpAgainstBetter = getWinPercentageGreaterThan(.5, $thisRow[1]);
    if ($thisRow[6] == 0) $wp = "NA";
    echo "$name: $wp ($gamesPlayed)    Win Percentage against > .500 : $wpAgainstBetter<br>";
}

function sortByWinPercentage($a, $b)
{
    $awp = (float)$a[5] / (float)$a[6];
    $bwp = (float)$b[5] / (float)$b[6];

    if ($awp == $bwp) return 0;
    return ($awp < $bwp) ? -1 : 1;

}

//function sortByPoints($a, $b) {
//    if ($a[0] == $b[0]) return 0;
//    return ($a[0] < $b[0]) ? -1 : 1;
//}