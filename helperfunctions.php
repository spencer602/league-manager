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

function getPlayerRankForID($playerID) {

}