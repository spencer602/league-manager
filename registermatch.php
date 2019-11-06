<?php
$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'user14';   // ...variables according
$dbpass  = '14rone';   // ...to your installation


$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");



function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2");
    return $result;
}




$p1 = $_POST["player1"];
$p2 = $_POST["player2"];

$p1gamesToWin = $_POST["playerOneGamesInput"];
$p2gamesToWin = $_POST["playerTwoGamesInput"];

$p1points = $_POST["playerOnePointsInput"];
$p2points = $_POST["playerTwoPointsInput"];

$p1gamesWon = $_POST["playerOneGamesWonInput"];
$p2gamesWon = $_POST["playerTwoGamesWonInput"];

$location = $_POST["locationPlayed"];


$p1id = queryMysql("SELECT player_id from players where player_name = '$p1'");
$p1id = $p1id->fetch_array(MYSQLI_ASSOC);
$p1id = $p1id['player_id'];

$p2id = queryMysql("SELECT player_id from players where player_name = '$p2'");
$p2id = $p2id->fetch_array(MYSQLI_ASSOC);
$p2id = $p2id['player_id'];

$loc_id = queryMysql("SELECT location_id from locations where location_name = '$location'");
$loc_id = $loc_id->fetch_array(MYSQLI_ASSOC);
$loc_id = $loc_id['location_id'];


// $dateAndTime =

// $value = $contents['playerid'];

//print_r($p1id);


$q = "insert into matches
(p1_id, p2_id, p1_points_wagered, p2_points_wagered, p1_games_needed,
  p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time,
  location_played)
  values
  ($p1id, $p2id, $p1points, $p2points, $p1gamesToWin, $p2gamesToWin,
  $p1gamesWon, $p2gamesWon, 0, 0, NOW(), $loc_id);";

queryMysql($q);

?>
