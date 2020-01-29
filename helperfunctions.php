<?php

include_once 'sqlscripts.php';

function getPlayerNamesForSeason($seasonID) {
    $sql = queryDB("SELECT * FROM players, registrations WHERE players.player_id = registrations.player_id 
                            AND registrations.season_id = '$seasonID' ORDER BY player_name");
    $playerNames = array();
    while ($row = $sql->fetch_assoc()){
        array_push($playerNames, $row['player_name']);
//        echo "<option value= \"" . $row['player_name'] . "\">" . $row['player_name'] . "</option>";
    }
    return $playerNames;
}

function getAllPlayerNames() {
    $sql = queryDB("SELECT player_name FROM players ORDER BY player_name");
    $playerNames = array();
    while ($row = $sql->fetch_assoc()){
        array_push($playerNames, $row['player_name']);
//        echo "<option value= \"" . $row['player_name'] . "\">" . $row['player_name'] . "</option>";
    }
    return $playerNames;
}

function getPlayerNameForID($playerID) {
    $data = queryDB("SELECT player_name FROM players WHERE player_id = '$playerID';");
    $player = $data->fetch_array(MYSQLI_ASSOC);
    $name = $player['player_name'];
    return $name;
}

function displayTourneyResults($tourneyID) {

    $tourneyData = queryDB("SELECT * FROM tournament_results WHERE tournament_id = '$tourneyID' ORDER BY position;");

    while ($row = $tourneyData->fetch_assoc()) {
        $name = getPlayerNameForID($row['player_id']);
        $result = $row['position'];
        $points = $row['points'];
        $plusSign = $points > 0 ? "+" : "";
        echo "$result: $name $plusSign$points<br>";
    }
}

function getAllTourneyMatchIDsForSeason($seasonID) {
    $query = "SELECT match_id FROM tournaments, tournament_matches WHERE tournaments.tournament_id = tournament_matches.tournament_id AND
            tournaments.season_id = '$seasonID';";

    $tourneyMatches = queryDB($query);
    $allMatchIDs = array();

    while ($row = $tourneyMatches->fetch_assoc()) {
        array_push($allMatchIDs, $row['match_id']);
    }

    return $allMatchIDs;
}

function getPlayerRankForID($playerID) {

}