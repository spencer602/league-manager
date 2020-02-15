<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>
    <link rel="stylesheet" href="css/matchhistory.css">

<?php

$seasonID = 2;

require 'header.php';
include_once 'LeagueManager.php';

session_start();
$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}
list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);
if ($validateMatch != 1) { header("location: adminloginform.php"); }

echo "<body>";
echo "<script>setTitle('Validate Matches')</script>";
echo "<script>setCurrentPage('Validate Matches')</script>";

$allMatches = LeagueManager::getUnpaidMatchesFor($seasonID);

echo "<form action = 'validatematches.php' method = 'post'>";

for ($i = 0; $i < count($allMatches); $i++) {
    echo '<br><hr><br>';

    $id = $allMatches[$i]->matchID;
    echo "<div class = 'validateMatchDiv'>";
    echo "<input type = 'checkbox' name = '$id' value = '1'>";
    echo "<span class = 'idSpan'>$id</span><span class = 'matchSpan'>";
    displayMatch($allMatches[$i], true, "");
    echo "<br></span></div>";
}

echo '<br><hr><br>';

echo "<input type = 'submit' id='subbut'>";

?>
<div id="footer">
    <p>Big Sky Shark Hunt, Founded 2019</p>
</div>
</body>
</div>
</html>