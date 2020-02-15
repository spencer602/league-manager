<?php

include_once 'LeagueManager.php';

session_start();
$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}
list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);
if ($validateMatch != 1) { header("location: adminloginform.php"); }

$seasonID = 2;
$leagueManager = new LeagueManager();

$matches = $leagueManager::getUnpaidMatchesFor($seasonID);

for ($i = 0; $i < count($matches); $i++) {
    $matchID = $matches[$i]->matchID;
    if ($_POST[$matchID] == 1) {
        $leagueManager::markMatchPaid($matchID);
    }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>
    <link rel="stylesheet" href="css/registered.css">

    <?php
    require 'header.php';
    echo "<body>";
    echo "<script>setTitle('Validate Matches')</script>";
    echo "<script>setCurrentPage('Validate Matches')</script>";

    echo '<br>';

    echo '<p id="content">Thank you for validating the matches!<br>';
    echo "<a href = 'validatematchesform.php'>Back to Validate Matches</a><br>";
    echo "<a href = 'admin.php'>Back to Admin</a></p>";

    ?>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>