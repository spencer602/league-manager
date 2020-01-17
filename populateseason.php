<?php
$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'spencer';   // ...variables according
$dbpass  = 'salute';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

$allPlayers = mysqli_query($connection, "SELECT player_id from players");
$position = 0;

while ($row = $allPlayers->fetch_assoc()) {
    $id = $row['player_id'];

    mysqli_query($connection, "INSERT INTO registrations
(season_id, player_id, paid)
  VALUES
  (1, $id, 1);");

    //mysqli_query($connection, "UPDATE registrations SET paid = 1");

//    mysqli_query($connection, "UPDATE players SET points = 250, games_played = 0, games_won = 0, eros = 0,
//        matches_played = 0, matches_won = 0 WHERE player_id = $id");
}