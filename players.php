<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Players</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/standings.css">
</head>
<div id="wrapper">
    <body>
    <div id="header">
        <div id="logo">
            <a href="index.php"><img src="images/logo.jpg" id="logo"></a><br>
        </div>
        <div id="pageName">
            <h1>Big Sky</h1><br>
            <h1>Shark Hunt</h1><br>
            <h1>Player List</h1>
        </div>
    </div>
    <div id="nav">
        <ul id="navbar">
            <li><a href = "registermatchform.php">Register</a><br></li>
            <li><a href = "displayallmatches.php">History</a><br></li>
            <li><a href = "index.php">Standings</a></li>
            <li><a href = "players.php">Players</a></li>

        </ul>
    </div>
    <br>

    <form action = "players.php" method = "post">
        <label id = "sortLabel">Sort Players By...</label><br>
        <select id = "sortBy" name="sortBy" class = "input">
            <option value="none" selected disabled hidden>Sort by...</option>
            <option value = "name">Name</option>
            <option value = "points">Points</option>
            <option value = "rank">Rank</option>
            <option value = "gamePercentage">Game Win Percentage</option>
            <option value = "ero">EROs</option>
            <option value = "gamesPlayed">Games Played</option>
            <option value = "matchesPlayed">Matches Played</option>
            <option value = "gamesWon">Games Won</option>
            <option value = "matchesWon">Matches Won</option>

        </select>

        <input type = "submit" id="subbut" value = "Sort">
    </form>
    <br><hr><br>

    <?php

    include_once 'calculatescore.php';
    include_once 'player.php';
    include_once 'sqlscripts.php';
    include_once 'leaguemanager.php';


    $seasonID = 2;

    $leagueManager = new LeagueManager();
    $leagueManager->updateForSeason($seasonID);

    $allPlayerData = $leagueManager->getAllPlayerData();


    if ($_POST['sortBy'] == "name") {
        usort($allPlayerData, "sortByName");
    }
    else if ($_POST['sortBy'] == "points") {
        usort($allPlayerData, "sortByPoints");
    }
    else if ($_POST['sortBy'] == "rank") {
        usort($allPlayerData, "sortByRank");
    }
    else if ($_POST['sortBy'] == "gamePercentage") {
        usort($allPlayerData, "sortByWinPercentage");
    }
    else if ($_POST['sortBy'] == "ero") {
        usort($allPlayerData, "sortByERO");
    }
    else if ($_POST['sortBy'] == "gamesPlayed") {
        usort($allPlayerData, "sortByGamesPlayed");
    }
    else if ($_POST['sortBy'] == "matchesPlayed") {
        usort($allPlayerData, "sortByMatchesPlayed");
    }
    else if ($_POST['sortBy'] == "gamesWon") {
        usort($allPlayerData, "sortByGamesWon");
    }
    else if ($_POST['sortBy'] == "matchesWon") {
        usort($allPlayerData, "sortByMatchesWon");
    }
    else {
        usort($allPlayerData, "sortByName");
    }
//    $position = 0;

    echo '<table id="standingsTable">';


    for ($i = 0; $i < count($allPlayerData); $i++) {
        $playerData = $allPlayerData[$i];

        $position = $leagueManager->getPositionForPlayerWithID($playerData->id);
        $points = $playerData->points + 250;
        $rank = $playerData->rank;
        $name = $playerData->name;
        $gamesWon = $playerData->gamesWon;
        $gamesPlayed = $playerData->gamesPlayed;
        $matchesWon = $playerData->matchesWon;
        $matchesPlayed = $playerData->matchesPlayed;
        $eros = $playerData->eros;
        $matchPercentage = $playerData->getMatchPercentage();
        $gamePercentage = $playerData->getWinPercentage();
        $phoneNumber = $playerData->phoneNumber;

        if ($matchPercentage != -1) {
            $matchPercentage = number_format((float)$matchPercentage, 1, '.', '');
        } else {
            $matchPercentage = "NA";
        }

        if ($gamePercentage != -1) {
            $gamePercentage = number_format((float)$gamePercentage, 1, '.', '');
        } else {
            $gamePercentage = "NA";
        }

        echo "<div class = 'firstRowOfCell'>$name</div>";
        echo "<div>Place in Standings: $position</div>";
        echo "<div>Points: $points</div>";
        echo "<div>Skill Rank (1-4): $rank</div>";
        echo "<div>Matches: $matchPercentage% ($matchesWon/$matchesPlayed)";
        echo "<div>Games: $gamePercentage% ($gamesWon/$gamesPlayed)";
        echo "<div>EROs: $eros";
        echo "<div>Phone: $phoneNumber";

        echo "<br><br><hr><br>";

//        echo "<tr><td class = 'positionTD'><span class = 'positionSpan'>$position</span></td>
//        <td><div class = 'firstRowOfCell'>$points $name: $rank</div>
//        <div class = 'secondRowOfCell'>Matches: $matchPercentage% ($matchesWon/$matchesPlayed)</div>
//        <div class = 'thirdRowOfCell'>Games: $gamePercentage% ($gamesWon/$gamesPlayed) - ERO: $eros</div></td></tr>";
    }

    function sortByName($a, $b) {
        if ($a->name == $b->name) { return 0; }
        return ($a->name < $b->name) ? -1: 1;
    }

    function sortByPoints($a, $b) {
        if ($a->points == $b->points){
            if ($a->getWinPercentage() == $b->getWinPercentage()) {
                return 0;
            }
            return ($a->getWinPercentage() < $b->getWinPercentage()) ? 1 : -1;
        }
        return ($a->points < $b->points) ? 1 : -1;
    }

    function sortByRank($a, $b) {
        if ($a->rank == $b->rank) { return 0; }
        return ($a->rank < $b->rank) ? -1 : 1;
    }

    function sortByWinPercentage($a, $b) {
        if ($a->getWinPercentage() == $b->getWinPercentage()) { return 0; }
        return ($a->getWinPercentage() < $b->getWinPercentage()) ? 1 : -1;
    }

    function sortByERO($a, $b) {
        if ($a->eros == $b->eros) { return 0; }
        return ($a->eros < $b->eros) ? 1 : -1;
    }

    function sortByGamesPlayed($a, $b) {
        if ($a->gamesPlayed == $b->gamesPlayed) { return 0; }
        return ($a->gamesPlayed < $b->gamesPlayed) ? 1 : -1;
    }

    function sortByMatchesPlayed($a, $b) {
        if ($a->matchesPlayed == $b->matchesPlayed) { return 0; }
        return ($a->matchesPlayed < $b->matchesPlayed) ? 1 : -1;
    }

    function sortByGamesWon($a, $b) {
        if ($a->gamesWon == $b->gamesWon) { return 0; }
        return ($a->gamesWon < $b->gamesWon) ? 1 : -1;
    }

    function sortByMatchesWon($a, $b) {
        if ($a->matchesWon == $b->matchesWon) { return 0; }
        return ($a->matchesWon < $b->matchesWon) ? 1 : -1;
    }


    echo "</table>";?>

    <div id="footer">
        <p>Big Sky Shark Hunt, Founded 2019</p>
    </div>
    </body>
</div>
</html>