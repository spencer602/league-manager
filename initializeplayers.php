<?php
$dbhost  = 'localhost';

$dbname  = 'db14';   // Modify these...
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

$p1id = queryMysql("SELECT sqrt(25)");


// $p1id = queryMysql("SELECT playerid FROM player WHERE name = '$p1'");

echo $p1id;

// $q = "insert into matches
//   (p1id, p2id, p1pointswagered, p2pointswagered, p1gamesneeded,
//   p2gamesneeded, p1gameswon, p2gameswon, p1ero, p2ero, dateandtime,
//   location)
//   values
//   ($p1, $p2, $p1gamesToWin, $p2gamesToWin, $p1points, $p2points,
//   $p1gamesWon, $p2gamesWon, 0, 0, NOW(), $location);";
//
// queryMysql($q);

?>
