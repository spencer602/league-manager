<?php
include_once 'LeagueManager.php';

session_start();
$admin = $_SESSION['adminLoggedIn'];
if ($admin == null) {
    header("location: adminloginform.php");
}
list($addPlayer, $registerPlayer, $registerTourney, $markPaid, $registerMatch, $validateMatch) = LeagueManager::getAdminPrivilegesFor($admin);
if ($registerTourney != 1) { header("location: adminloginform.php"); }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register A Player</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/registermatchform.css">
</head>
<!--<script src="registermatch2020.js"></script>-->
<!--<script src="inputBoxChange.js"></script>-->
<div id="wrapper">
    <div id ="header">
        <a href="index.php"><img src="images/logo.jpg" id="logo"></a>
        <div id="pageName">
            <h1>Big Sky</h1><br>
            <h1>Shark Hunt</h1><br>
            <h1>Register Player</h1>
        </div>
    </div>
    <div id="nav">
        <ul id="navbar">
            <li><a href = "registermatchform.php">Register</a><br></li>
            <li><a href = "displayallmatches.php">History</a><br></li>
            <li><a href = "index.php">Standings</a></li>
        </ul>
    </div>
    <div id="container">
        <form action = "registertournamentresult.php" method = "post">
            <div id="p1">
                <h3>Player:</h3>
                <select id = "player" name="player" class = "input">
                    <?php
                    include_once 'helperfunctions.php';
                    $playerNames = getPlayerNamesForSeason(2);
                    for ($i = 0; $i < count($playerNames); $i++) {
                        echo "<option value= \"" . $playerNames[$i] . "\">" . $playerNames[$i] . "</option>";
                    }
                    ?>
                </select>
                <br><br>

            </div>

            <div id="passwords">
                <label id = "tournamentIDLabel">Tournament ID:</label><br>
                <input type = "text" name = "tournamentID" id = "tournamentID" class = "input">
                <br><br>
                <label id = "pointsLabel">Points:</label><br>
                <input type = "text" name = "points" id = "points" class = "input">
                <br><br>

                <br>
            </div>
            <div class="spacer"></div><br>
            <input type = "submit" id="subbut">
        </form>
        <br>
    </div>
    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>