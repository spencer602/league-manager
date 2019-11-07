<?php
$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'user14';   // ...variables according
$dbpass  = '14rone';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");   // if there is a connection error

// queries the database with the given query, "Fatal Error 2" upon error
function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2: . $query");
    return $result;
}

// gathers the data from the form
$formP1Name = $_POST["player1"];
$formP2Name = $_POST["player2"];
$formP1GamesToWin = $_POST["playerOneGamesInput"];
$formP2GamesToWin = $_POST["playerTwoGamesInput"];
$formP1PointsWagered = $_POST["playerOnePointsInput"];
$formP2PointsWagered = $_POST["playerTwoPointsInput"];
$formP1GamesWon = $_POST["playerOneGamesWonInput"];
$formP2GamesWon = $_POST["playerTwoGamesWonInput"];
$formLocationName = $_POST["locationPlayed"];

// queries the player table
$p1Row = queryMysql("SELECT * FROM players WHERE player_name = '$formP1Name'");
$p1Row = $p1Row->fetch_array(MYSQLI_ASSOC);
$p1ID = $p1Row['player_id'];

$p2Row = queryMysql("SELECT * FROM players WHERE player_name= '$formP2Name'");
$p2Row = $p2Row->fetch_array(MYSQLI_ASSOC);
$p2ID = $p2Row['player_id'];

// gets the location data from the locationName via the 'locations' table
$locationRow = queryMysql("SELECT * FROM locations WHERE location_name = '$formLocationName'");
$locationRow = $locationRow->fetch_array(MYSQLI_ASSOC);
$locationID = $locationRow['location_id'];

// the query we are using for inserting the match into the table
$insertQueryString = "INSERT INTO matches
(p1_id, p2_id, p1_points_wagered, p2_points_wagered, p1_games_needed,
  p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time,
  location_played)
  VALUES
  ($p1ID, $p2ID, $formP1PointsWagered, $formP2PointsWagered, $formP1GamesToWin, $formP2GamesToWin,
  $formP1GamesWon, $formP2GamesWon, 0, 0, NOW(), $locationID);";

// send the query to the database
queryMysql($insertQueryString);

$p1IsWinner = false;

// determines the winner
if ($formP1GamesWon == $formP1GamesToWin) {
    $p1IsWinner = true;
}

// gather the current points for the plaeyers
$p1TotalPoints = $p1Row['points'];
$p2TotalPoints = $p2Row['points'];

// matches and games played at the location
$gamesPlayedAtLocation = $locationRow['games_played'] + $formP2GamesWon + $formP1GamesWon;
$matchesPlayedAtLocation = $locationRow['matches_played'] + 1;

// update the stats for player1
$p1TotalGameWins = $p1Row['games_won'] + $formP1GamesWon;
$p1TotalGamesPlayed = $p1Row['games_played'] + $formP2GamesWon + $formP1GamesWon;
$p1TotalMatchWins = $p1Row['matches_won'];
$p1TotalMatchesPlayed = $p1Row['matches_played'] + 1;
//$p1eros = $p1['eros'] + eros from input

// update the stats for player2
$p2TotalGameWins = $p2Row['games_won'] + $formP2GamesWon;
$p2TotalGamesPlayed = $p2Row['games_played'] + $formP2GamesWon + $formP1GamesWon;
$p2TotalMatchWins = $p2Row['matches_won'];
$p2TotalMatchesPlayed = $p2Row['matches_played'] + 1;
//$p2eros = $p2['eros'] + eros from input

// update the stats based on winner: assigning points (even if there is a point handicap given)
// NOTE: if p1 is winner, then the number of points won/lost by each is determined by how much player2 wagered
if ($p1IsWinner) {
    $p1TotalPoints += $formP2PointsWagered;
    $p2TotalPoints -= $formP2PointsWagered;
    $p1TotalMatchWins += 1;
} else {    // NOTE: if p2 is winner, then the number of points won/lost by each is determined by how much player1 wagered
    $p1TotalPoints -= $formP1PointsWagered;
    $p2TotalPoints += $formP1PointsWagered;
    $p2TotalMatchWins +=1;
}

// update the players table and locations table with the new player and location data
queryMysql("UPDATE players SET points = $p1TotalPoints, games_played = $p1TotalGamesPlayed, games_won = $p1TotalGameWins, 
            matches_played = $p1TotalMatchesPlayed, matches_won = $p1TotalMatchWins WHERE player_id = $p1ID");

queryMysql("UPDATE players SET points = $p2TotalPoints, games_played = $p2TotalGamesPlayed, games_won = $p2TotalGameWins, 
            matches_played = $p2TotalMatchesPlayed, matches_won = $p2TotalMatchWins WHERE player_id = $p2ID");

queryMysql("UPDATE locations SET games_played = $gamesPlayedAtLocation, matches_played = $matchesPlayedAtLocation WHERE location_id = $locationID ");


// this is what is displayed after a match is registered. This could be improved to look better

echo "match registered<br>";
echo "<a href = 'index.php'>Back to Home</a>";