<?php

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'user14';   // ...variables according
$dbpass  = '14rone';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

$allMatches = mysqli_query($connection, "SELECT * from matches");

while ($row = $allMatches->fetch_assoc()) {
    $p1id = $row['p1id'];
    $p2id = $row['p2id'];

    // echo "<p>$p1id played $p2id</p>";


    $p1name = mysqli_query($connection, "SELECT name FROM player where playerid = '$p1id'");
    $p2name = mysqli_query($connection, "SELECT name FROM player where playerid = '$p2id'");

    $p1name = $p1name->fetch_array(MYSQLI_ASSOC);
    $p1name = $p1name['name'];

    $p2name = $p2name->fetch_array(MYSQLI_ASSOC);
    $p2name = $p2name['name'];

    $p1gamesToWin = $row['p1gamesneeded'];
    $p2gamesToWin = $row['p2gamesneeded'];

    $p1gamesWon = $row['p1gameswon'];
    $p2gamesWon = $row['p2gameswon'];

    $p1pointsWagered = $row['p1pointswagered'];
    $p2pointsWagered = $row['p2pointswagered'];

    echo "<p>$p1name: $p1gamesWon/$p1gamesToWin vs $p2name: $p2gamesWon/$p2gamesToWin</p>";
}

