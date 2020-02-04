<?php

include_once 'LeagueManager.php';

$seasonID = 2;
$leagueManager = new LeagueManager();

$matchID = $leagueManager->addMatch($_POST['player1'], $_POST['player2'], $_POST['playerOneGamesWonInput'],
    $_POST['playerTwoGamesWonInput'], $_POST['playerOneEROInput'], $_POST['playerTwoEROInput'],
    $_POST['locationPlayed'], $_POST['playerOnePassword'], $_POST['playerTwoPassword'], $seasonID);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>
    <link rel="stylesheet" href="css/registered.css">

    <?php
    require 'header.php';
    echo "<body>";
    echo "<script>setTitle('Register Match')</script>";
    echo "<script>setCurrentPage('Register Match')</script>";

    echo '<br>';

    echo '<p id="content">Thank you for registering your match!<br>';
    echo "Please write your match ID on your envelope!<br> Match ID: $matchID<br>";
    echo "<a href = 'displayallmatches.php'>Back to Match History</a></p>";
    ?>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>