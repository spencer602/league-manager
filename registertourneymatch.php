<?php

include_once 'LeagueManager.php';

session_start();
$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}
list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);
if ($registerTourney != 1) { header("location: adminloginform.php"); }


include_once 'sqlscripts.php';

// gathers the data from the form
$formP1Name = $_POST["player1"];
$formP2Name = $_POST["player2"];
//$formP1GamesToWin = $_POST["playerOneGamesInput"];
//$formP2GamesToWin = $_POST["playerTwoGamesInput"];
//$formP1PointsWagered = $_POST["playerOnePointsInput"];
//$formP2PointsWagered = $_POST["playerTwoPointsInput"];
$formP1GamesWon = $_POST["playerOneGamesWonInput"];
$formP2GamesWon = $_POST["playerTwoGamesWonInput"];
$formLocationName = $_POST["locationPlayed"];
$formP1ERO = $_POST["playerOneEROInput"];
$formP2ERO = $_POST["playerTwoEROInput"];
$tourneyID = $_POST['tourneyID'];
$round = $_POST['roundNumber'];

//$p1password = $_POST["playerOnePassword"];
//$p2password = $_POST["playerTwoPassword"];

$formP1GamesToWin = 7;
$formP2GamesToWin = 7;

$formP1PointsWagered = 15;
$formP2PointsWagered = 15;

// queries the player table
$p1Row = queryDB("SELECT * FROM players WHERE player_name = '$formP1Name'");
$p1Row = $p1Row->fetch_array(MYSQLI_ASSOC);
$p1ID = $p1Row['player_id'];
$p1Hash = $p1Row['password'];
$p1Rank = $p1Row['rank'];

$p2Row = queryDB("SELECT * FROM players WHERE player_name= '$formP2Name'");
$p2Row = $p2Row->fetch_array(MYSQLI_ASSOC);
$p2ID = $p2Row['player_id'];
$p2Hash = $p2Row['password'];
$p2Rank = $p2Row['rank'];

$seasonID = 2;
$defaultPaidNo = 0;

//if (!password_verify($p1password, $p1Hash)) { die("Invalid Password for $formP1Name"); }
//if (!password_verify($p2password, $p2Hash)) { die("Invalid Password for $formP2Name"); }


if ($p1Rank <= $p2Rank) {
    $formP1GamesToWin = 7;
    $formP2GamesToWin = 7 - ($p2Rank - $p1Rank);
} else {
    $formP2GamesToWin = 7;
    $formP1GamesToWin = 7 - ($p1Rank - $p2Rank);
}

// gets the location data from the locationName via the 'locations' table
$locationRow = queryDB("SELECT * FROM locations WHERE location_name = '$formLocationName'");
$locationRow = $locationRow->fetch_array(MYSQLI_ASSOC);
$locationID = $locationRow['location_id'];

// the query we are using for inserting the match into the table
$insertQueryString = "INSERT INTO matches
(p1_id, p2_id, p1_points_wagered, p2_points_wagered, p1_games_needed,
  p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time,
  location_played, paid, season, p1_rank, p2_rank)
  VALUES
  ($p1ID, $p2ID, $formP1PointsWagered, $formP2PointsWagered, $formP1GamesToWin, $formP2GamesToWin,
  $formP1GamesWon, $formP2GamesWon, $formP1ERO, $formP2ERO, NOW(), $locationID, $defaultPaidNo, $seasonID, $p1Rank, $p2Rank);";

// send the query to the database
queryDB($insertQueryString);

$data = queryDB("SELECT match_id FROM matches ORDER BY match_id DESC;");
$row = $data->fetch_assoc();
$matchID = $row['match_id'];

$query = "INSERT INTO tournament_matches (tournament_id, match_id, round) VALUES ($tourneyID, $matchID, $round);";
queryDB($query);

//queryDB("SELECT match_id FROM matches ORDER BY match_id;")


//$p1IsWinner = false;
//
//// determines the winner
//if ($formP1GamesWon == $formP1GamesToWin) {
//    $p1IsWinner = true;
//}
//
//// gather the current points for the plaeyers
//$p1TotalPoints = $p1Row['points'];
//$p2TotalPoints = $p2Row['points'];
//
//// matches and games played at the location
//$gamesPlayedAtLocation = $locationRow['games_played'] + $formP2GamesWon + $formP1GamesWon;
//$matchesPlayedAtLocation = $locationRow['matches_played'] + 1;
//
//// update the stats for player1
//$p1TotalGameWins = $p1Row['games_won'] + $formP1GamesWon;
//$p1TotalGamesPlayed = $p1Row['games_played'] + $formP2GamesWon + $formP1GamesWon;
//$p1TotalMatchWins = $p1Row['matches_won'];
//$p1TotalMatchesPlayed = $p1Row['matches_played'] + 1;
//$p1eros = $p1Row['eros'] + $formP1ERO;
//
//// update the stats for player2
//$p2TotalGameWins = $p2Row['games_won'] + $formP2GamesWon;
//$p2TotalGamesPlayed = $p2Row['games_played'] + $formP2GamesWon + $formP1GamesWon;
//$p2TotalMatchWins = $p2Row['matches_won'];
//$p2TotalMatchesPlayed = $p2Row['matches_played'] + 1;
//$p2eros = $p2Row['eros'] + $formP2ERO;
//
//// update the stats based on winner: assigning points (even if there is a point handicap given)
//// NOTE: if p1 is winner, then the number of points won/lost by each is determined by how much player2 wagered
//if ($p1IsWinner) {
//    $p1TotalPoints += $formP2PointsWagered;
//    $p2TotalPoints -= $formP2PointsWagered;
//    $p1TotalMatchWins += 1;
//} else {    // NOTE: if p2 is winner, then the number of points won/lost by each is determined by how much player1 wagered
//    $p1TotalPoints -= $formP1PointsWagered;
//    $p2TotalPoints += $formP1PointsWagered;
//    $p2TotalMatchWins +=1;
//}
//
//// update the players table and locations table with the new player and location data
//queryMysql("UPDATE players SET eros = $p1eros, points = $p1TotalPoints, games_played = $p1TotalGamesPlayed, games_won = $p1TotalGameWins,
//            matches_played = $p1TotalMatchesPlayed, matches_won = $p1TotalMatchWins WHERE player_id = $p1ID");
//
//queryMysql("UPDATE players SET eros = $p2eros, points = $p2TotalPoints, games_played = $p2TotalGamesPlayed, games_won = $p2TotalGameWins,
//            matches_played = $p2TotalMatchesPlayed, matches_won = $p2TotalMatchWins WHERE player_id = $p2ID");
//
//queryMysql("UPDATE locations SET games_played = $gamesPlayedAtLocation, matches_played = $matchesPlayedAtLocation WHERE location_id = $locationID ");?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register A Match</title>
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
            <h1>Match Form</h1>
        </div>
    </div>
    <div id="nav">
        <ul id="navbar">
            <li><a href = "registermatchform.php">Register</a><br></li>
            <li><a href = "displayallmatches.php">History</a><br></li>
            <li><a href = "index.php">Standings</a></li>
        </ul>
    </div>
    <?php
    include_once 'sqlscripts.php';
    $data = queryDB("SELECT match_id FROM matches ORDER BY match_id DESC;");
    $row = $data->fetch_assoc();
    $matchID = $row['match_id'];
    echo '<p id="content">Thank you for registering your match!<br>';
    echo "Please write your match ID on your envelope! Match ID: $matchID</p>";
    ?>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>