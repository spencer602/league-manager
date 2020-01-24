<?php

include_once 'sqlscripts.php';
$playerName = $_POST["player_name"];

$queryResults = queryDB("SELECT rank FROM players WHERE player_name = '$playerName'");

$playerRank = "Error";

while ($row = $queryResults->fetch_assoc()) {
    $playerRank = $row['rank'];
}

echo $playerRank;