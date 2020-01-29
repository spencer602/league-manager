<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Match History</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/matchhistory.css">
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
			<h1>Match History</h1>
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

include_once 'sqlscripts.php';
include_once 'helperfunctions.php';

function displayTourneyMatches($tourneyID) {
    $query = "SELECT * from tournament_matches WHERE tournament_id = '$tourneyID' ORDER BY round;";
    $tourneyMatches = queryDB($query);
    $round = "";

    while ($row = $tourneyMatches->fetch_assoc()) {
        $matchID = $row['match_id'];
//        $round = $row['round'];

        $matchData = queryDB("SELECT * FROM matches WHERE match_id = '$matchID';");

        $match = $matchData->fetch_array(MYSQLI_ASSOC);

        $p1id = $match['p1_id'];
        $p2id = $match['p2_id'];

        $p1name = queryDB("SELECT player_name FROM players where player_id = '$p1id'");
        $p2name = queryDB("SELECT player_name FROM players where player_id = '$p2id'");

        $p1name = $p1name->fetch_array(MYSQLI_ASSOC);
        $p1name = $p1name['player_name'];

        $p2name = $p2name->fetch_array(MYSQLI_ASSOC);
        $p2name = $p2name['player_name'];

        $p1gamesToWin = intval($match['p1_games_needed']);
        $p2gamesToWin = intval($match['p2_games_needed']);

        $p1gamesWon = intval($match['p1_games_won']);
        $p2gamesWon = intval($match['p2_games_won']);

        $p1ero = intval($match['p1_ero']);
        $p2ero = intval($match['p2_ero']);

        $winner = "";
        $loser = "";

        if ($p1gamesWon == $p1gamesToWin) {
//        $winner = $p1name;
            $winner = "$p1name: $p1gamesWon/$p1gamesToWin";
            if ($p1ero > 0) {
                $winner = "$winner  ERO: $p1ero";
            }

//        $loser = $p2name;
            $loser = "$p2name: $p2gamesWon/$p2gamesToWin";
            if ($p2ero > 0) {
                $loser = "$loser  ERO: $p2ero";
            }
        } else {
//        $winner = $p2name;
            $winner = "$p2name: $p2gamesWon/$p2gamesToWin";
            if ($p2ero > 0) {
                $winner = "$winner  ERO: $p2ero";
            }
//        $loser = $p1name;
            $loser = "$p1name: $p1gamesWon/$p1gamesToWin";
            if ($p1ero > 0) {
                $loser = "$loser  ERO: $p1ero";
            }
        }
        $roundData = "";
        if ($round != $row['round']) {
            $round = $row['round'];
            $roundData = "<div class = 'dateTimeDiv'>Round: $round</div><br>";
        }

        echo "<span class = 'matchDiv'>
            <br>
            $roundData
            <div class = 'winnerDiv'>$winner</div>
            <div class = 'loserDiv'>$loser</div>
          </span>";
    }
}

$seasonID = 2;

// all fields of all matching queries
$allMatches = queryDB("SELECT * from matches WHERE season = $seasonID ORDER BY date_and_time DESC");

$tourneyMatchIDs = getAllTourneyMatchIDsForSeason(2);
$tourneyIDsThatHaveBeenDisplayed = array();

while ($row = $allMatches->fetch_assoc()) {

    $matchID = $row['match_id'];

    if (in_array($matchID, $tourneyMatchIDs)) {
        $row = queryDB("SELECT tournament_id FROM tournament_matches WHERE match_id = '$matchID';");
        $row = $row->fetch_array(MYSQLI_ASSOC);
        $tourneyID = $row['tournament_id'];

        if (!in_array($tourneyID, $tourneyIDsThatHaveBeenDisplayed)) {
            echo '<br><hr><br>';


            $tourneyData = queryDB("SELECT date FROM tournaments WHERE tournament_id = '$tourneyID';");
            $tourneyDate = $tourneyData->fetch_array(MYSQLI_ASSOC)['date'];

            $tourneyTime = DateTime::createFromFormat('Y-m-d', $tourneyDate);
            $dateString = $tourneyTime->format('D, M d');

            echo "<div class = 'dateTimeDiv'>$dateString</div>";
            echo "<div class = 'dateTimeDiv'>Tournament Results:</div><br>";

            displayTourneyResults($tourneyID);

            array_push($tourneyIDsThatHaveBeenDisplayed, $tourneyID);

            displayTourneyMatches($tourneyID);
        }
        continue;
    }


    $p1id = $row['p1_id'];
    $p2id = $row['p2_id'];

    $p1name = queryDB("SELECT player_name FROM players where player_id = '$p1id'");
    $p2name = queryDB("SELECT player_name FROM players where player_id = '$p2id'");

    $p1name = $p1name->fetch_array(MYSQLI_ASSOC);
    $p1name = $p1name['player_name'];

    $p2name = $p2name->fetch_array(MYSQLI_ASSOC);
    $p2name = $p2name['player_name'];

    $p1gamesToWin = intval($row['p1_games_needed']);
    $p2gamesToWin = intval($row['p2_games_needed']);

    $p1gamesWon = intval($row['p1_games_won']);
    $p2gamesWon = intval($row['p2_games_won']);

    $p1pointsWagered = intval($row['p1_points_wagered']);
    $p2pointsWagered = intval($row['p2_points_wagered']);

    $p1ero = intval($row['p1_ero']);
    $p2ero = intval($row['p2_ero']);

    // 2019-11-29 12:03:32

    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_and_time']);
    $dateTimeString = $dateTime->format('D, M d, h:i A');

    $winner = "";
    $loser = "";

    if ($p1gamesWon == $p1gamesToWin) {
//        $winner = $p1name;
        $winner = "$p1name +$p2pointsWagered: $p1gamesWon/$p1gamesToWin";
        if ($p1ero > 0) {
            $winner = "$winner  ERO: $p1ero";
        }

//        $loser = $p2name;
        $loser = "$p2name -$p2pointsWagered: $p2gamesWon/$p2gamesToWin";
        if ($p2ero > 0) {
            $loser = "$loser  ERO: $p2ero";
        }
    } else {
//        $winner = $p2name;
        $winner = "$p2name +$p1pointsWagered: $p2gamesWon/$p2gamesToWin";
        if ($p2ero > 0) {
            $winner = "$winner  ERO: $p2ero";
        }
//        $loser = $p1name;
        $loser = "$p1name -$p1pointsWagered: $p1gamesWon/$p1gamesToWin";
        if ($p1ero > 0) {
            $loser = "$loser  ERO: $p1ero";
        }
    }

    echo "<span class = 'matchDiv'>
            <br><hr><br>
            <div class = 'dateTimeDiv'>$dateTimeString</div>
            <div class = 'winnerDiv'>$winner</div>
            <div class = 'loserDiv'>$loser</div>
          </span>";



}?>
	<!--</table>-->

        <br><hr><br>

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>