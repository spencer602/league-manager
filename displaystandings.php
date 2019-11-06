<?php

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'user14';   // ...variables according
$dbpass  = '14rone';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

$allStandings = mysqli_query($connection, "SELECT * from players ORDER BY points DESC");
$position = 0;

while ($row = $allStandings->fetch_assoc()) {
    $position++;
    $points = $row['points'];
    $name = $row['player_name'];
    $gamesWon = $row['games_won'];
    $gamesPlayed = $row['games_played'];
    $matchesWon = $row['matches_won'];
    $matchesPlayed = $row['matches_played'];

    echo "$position: $points $name Matches: $matchesWon/$matchesPlayed   Games: $gamesWon/$gamesPlayed<br>";
    
}

echo "<a href = 'index.php'>Back to Home</a>";