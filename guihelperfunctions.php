<?php

include_once 'LeagueManager.php';
//include_once 'helperfunctions.php';
//include_once 'sqlscripts.php';

function makeOptionsFromPlayerNames($playerNames) {
    for ($i = 0; $i < count($playerNames); $i++) {
        echo "<option value= \"" . $playerNames[$i] . "\">" . $playerNames[$i] . "</option>";
    }
}

function makeOptionsFromLocationNames($locations) {
    for ($i = 0; $i < count($locations); $i++) {
        echo "<option value= \"" . $locations[$i] . "\">" . $locations[$i] . "</option>";
    }
}

function displayMatch($match, $includeDate, $roundData) {

    // 2019-11-29 12:03:32
    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $match->timestamp);
    $dateTimeString = $dateTime->format('D, M d, h:i A');

    $winnerString = "";
    list($id, $gamesWon, $gamesNeeded, $ero, $rank, $points) = $match->getWinnerData();
    $name = LeagueManager::getPlayerNameFromID($id);
    $name = "<a class = 'playerhref' href = 'playerdetail.php?id=$id'>$name</a>";
    if ($includeDate) { $points = "+$points"; }
    else { $points = ""; }

    $winnerString = "$name $points: $gamesWon/$gamesNeeded";
    if ($ero > 0) {
        $winnerString = "$winnerString  ERO: $ero";
    }

    $loserString = "";
    list($id, $gamesWon, $gamesNeeded, $ero, $rank, $points) = $match->getLoserData();
    $name = LeagueManager::getPlayerNameFromID($id);
    $name = "<a class = 'playerhref' href = 'playerdetail.php?id=$id'>$name</a>";
    if ($includeDate) { $points = "-$points"; }
    else { $points = ""; }

    $loserString = "$name $points: $gamesWon/$gamesNeeded";
    if ($ero > 0) {
        $loserString = "$loserString  ERO: $ero";
    }

    echo "<span class = 'matchDiv'>";
    echo "<br>";
    if ($includeDate) { echo "<hr><br>"; }
    if ($includeDate) { echo "<div class = 'dateTimeDiv'>$dateTimeString</div>"; }
    echo $roundData;
    echo "<div class = 'winnerDiv'>$winnerString</div>";
    echo "<div class = 'loserDiv'>$loserString</div>";
    echo "</span>";
}

function guidisplayTourneyResults($tourneyID) {
    $tourneyData = LeagueManager::getTournamentResultsFor($tourneyID);
    for ($i = 0; $i < count($tourneyData); $i++) {
        list($name, $result, $points, $id) = $tourneyData[$i];
        $name = "<a class = 'playerhref' href = 'playerdetail.php?id=$id'>$name</a>";
        $plusSign = $points > 0 ? "+" : "";
        echo "$result: $name $plusSign$points<br>";
    }
}

function guidisplayTourneyMatches($tourneyID) {
    $tourneyMatches = LeagueManager::getAllMatchesFor(null, null, $tourneyID);
    $round = null;

    for ($i = 0; $i < count($tourneyMatches); $i++) {
        $match = $tourneyMatches[$i];

        $roundData = "";
        if ($round != $match->round) {
            $round = $match->round;
            $roundData = "<div class = 'dateTimeDiv'>Round: $round</div><br>";
        }

        displayMatch($match, false, $roundData);
    }
}

function guidisplayAllMatches($matches) {
    $tourneyMatchIDs = LeagueManager::getAllTourneyMatchIDsForSeason(2);
    $tourneyIDsThatHaveBeenDisplayed = array();

    for ($i = 0; $i < count($matches); $i++) {
        $match = $matches[$i];

        $matchID = $match->matchID;

        if (in_array($matchID, $tourneyMatchIDs)) {
            $row = queryDB("SELECT tournament_id FROM tournament_matches WHERE match_id = '$matchID';");
            $row = $row->fetch_array(MYSQLI_ASSOC);
            $tourneyID = $row['tournament_id'];

            if (!in_array($tourneyID, $tourneyIDsThatHaveBeenDisplayed)) {
                echo '<br><hr><br>';


                $tourneyData = queryDB("SELECT date FROM tournaments WHERE tournament_id = '$tourneyID';");
                $tourneyDate = $tourneyData->fetch_array(MYSQLI_ASSOC)['date'];

                $tourneyTime = DateTime::createFromFormat('Y-m-d', $tourneyDate);
                $dateString = $tourneyTime->format('D, M d');

                echo "<div class = 'dateTimeDiv'>$dateString</div>";
                echo "<div class = 'dateTimeDiv'>Tournament Results:</div><br>";

                guidisplayTourneyResults($tourneyID);

                array_push($tourneyIDsThatHaveBeenDisplayed, $tourneyID);

                guidisplayTourneyMatches($tourneyID);
            }
            continue;
        }
        displayMatch($match, true, "");
    }
}

