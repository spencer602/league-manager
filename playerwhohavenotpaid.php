<?php
include_once 'sqlscripts.php';

$query = "SELECT player_name from players, registrations 
    WHERE players.player_id = registrations.player_id AND registrations.season_id = 2 AND registrations.paid = 0;";
$results = queryDB($query);
while ($row = $results->fetch_assoc()) {
    $name = $row['player_name'];
    echo "$name<br>";
}