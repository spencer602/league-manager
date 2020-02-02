<?php


session_start();

if ($_SESSION['adminLoggedIn'] != 1) {
    header("location: adminloginform.php");
}


include_once 'sqlscripts.php';

$tournamentID = $_POST['tournamentID'];
$playerName = $_POST['player'];
$points = $_POST['points'];

// queries the player table
$p1Row = queryDB("SELECT * FROM players WHERE player_name = '$playerName'");
$p1Row = $p1Row->fetch_array(MYSQLI_ASSOC);
$p1ID = $p1Row['player_id'];
$paid = 1;


$query = "INSERT INTO tournament_results (tournament_id, player_id, points, paid) VALUES ($tournamentID, $p1ID, $points, $paid);";

queryDB($query);