<?php
include_once 'LeagueManager.php';

session_start();
$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}
list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);
if ($registerTourney != 1) { header("location: adminloginform.php"); }



include_once 'sqlscripts.php';

$tournamentID = $_POST['tournamentID'];
$playerName = $_POST['player'];
$points = $_POST['points'];

// queries the player table
$p1Row = queryDB("SELECT * FROM players WHERE player_name = '$playerName'");
$p1Row = $p1Row->fetch_array(MYSQLI_ASSOC);
$p1ID = $p1Row['player_id'];
$paid = 1;
$position = 1;

$query = "INSERT INTO tournament_results (tournament_id, player_id, points, paid, position) VALUES ('$tournamentID', '$p1ID', '$points', '$paid', '$position');";


queryDB($query);

echo 'success';