<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Current Standings</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/standings.css">
</head>
<div id="wrapper">
	<body>
		<div id="header">
			<div id="logo">
			<a href="index.php"><img src="images/logo.jpg" id="logo"></a><br>
			</div>
			<div id="pageName">
			<h1>Big Sky</h1><br>
			<h1>Shark Hunt</h1><br>
			<h1>Current Standings</h1>
			</div>
		</div>
		<div id="nav">
			<ul id="navbar">
				<li><a href = "registermatchform.php">Register</a><br></li>
				<li><a href = "displayallmatches.php">History</a><br></li>
				<li><a href = "displaystandings.php">Standings</a></li>
			</ul>
		</div>
		<br>
<?php


include 'calculatescore.php';

include_once 'player.php';

//include 'allscores.php';


$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'spencer';   // ...variables according
$dbpass  = 'salute';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

$allIDs = mysqli_query($connection, "SELECT player_id from players");

$allPlayerData = array();

while ($row = $allIDs->fetch_assoc()) {
    $playerID = $row['player_id'];
    $playerData = getDataForPlayerID($playerID);
    array_push($allPlayerData, $playerData);
}


usort($allPlayerData, "sortByPoints");

$position = 0;

echo '<table id="standingsTable">';

for ($i = 0; $i < count($allPlayerData); $i++) {
    $position++;
    $playerData = $allPlayerData[$i];
    $points = $playerData->points + 250;
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
        <td><div class = 'firstRowOfCell'>$points $name</div>
        <div class = 'secondRowOfCell'>Matches: $matchPercentage% ($matchesWon/$matchesPlayed)</div>
        <div class = 'thirdRowOfCell'>Games: $gamePercentage% ($gamesWon/$gamesPlayed) - ERO: $eros</div></td></tr>";

}

function sortByPoints($a, $b) {
    if ($a->points == $b->points) return 0;
    return ($a->points < $b->points) ? 1 : -1;
}


//$allStandings = mysqli_query($connection, "SELECT * from players ORDER BY points DESC");
//$allStandings =

// position is the players position in the rankings
//$position = 0;
//echo '<table id="standingsTable">';
//while ($row = $allStandings->fetch_assoc()) {
//    $position++;
//    $points = $row['points'];
//    $name = $row['player_name'];
//    $gamesWon = $row['games_won'];
//    $gamesPlayed = $row['games_played'];
//    $matchesWon = $row['matches_won'];
//    $matchesPlayed = $row['matches_played'];
//    $eros = $row['eros'];
//    if ($matchesPlayed > 0) {
//        $matchPercentage = $matchesWon / $matchesPlayed * 100.0;
//        $matchPercentage = number_format((float)$matchPercentage, 1, '.', '');
//
//    } else {
//        $matchPercentage = "NA";
//    }
//
//    if ($gamesPlayed > 0) {
//        $gamePercentage = $gamesWon / $gamesPlayed * 100.0;
//        $gamePercentage = number_format((float)$gamePercentage, 1, '.', '');
//    } else {
//        $gamePercentage = "NA";
//    }
//
//
//    // this could be updated to look better
//    echo "<tr><td class = 'positionTD'><span class = 'positionSpan'>$position</span></td>
//        <td><div class = 'firstRowOfCell'>$points $name</div>
//        <div class = 'secondRowOfCell'>Matches: $matchPercentage% ($matchesWon/$matchesPlayed)</div>
//        <div class = 'thirdRowOfCell'>Games: $gamePercentage% ($gamesWon/$gamesPlayed) - ERO: $eros</div></td></tr>";
//
//}
echo "</table>";?>	

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>