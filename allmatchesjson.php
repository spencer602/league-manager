<?php

// Create connection

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'spencer';   // ...variables according
$dbpass  = 'salute';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

// all fields of all matching queries
$query = "SELECT p1.player_name AS p1name, p2.player_name AS p2name, p1_points_wagered, p2_points_wagered, 
    p1_games_needed, p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time, location_played 
            FROM players p1, matches, players p2 
            WHERE p1.player_id = p1_id AND p2.player_id = p2_id
            ORDER BY date_and_time DESC;";
$allPlayers = mysqli_query($connection, $query);

$resultArray = array();
$tempArray = array();


while ($row = $allPlayers->fetch_assoc()) {


    // Add each row into our results array
    $tempArray = $row;
    array_push($resultArray, $tempArray);
}

// Finally, encode the array to JSON and output the results
echo json_encode($resultArray);

// Close connections
mysqli_close($connection);
