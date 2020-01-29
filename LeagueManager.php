<?php
include_once 'sqlscripts.php';

function sortByPointsThenMatchPercentage($a, $b) {
    if ($a->points == $b->points){
        if ($a->getWinPercentage() == $b->getWinPercentage()) {
            return 0;
        }
        return ($a->getWinPercentage() < $b->getWinPercentage()) ? 1 : -1;
    }
    return ($a->points < $b->points) ? 1 : -1;
}

class LeagueManager
{
    public $allPlayers;

    public function __construct()
    {
        $this->allPlayers = array();
    }

    public function updateForSeason($seasonID) {
        $this->allPlayers = array();
        $query = "SELECT player_id FROM registrations WHERE season_id = '$seasonID';";
        $allPlayerIDsInSeason = queryDB($query);

        while($row = $allPlayerIDsInSeason->fetch_assoc()) {
            $playerID = $row['player_id'];
            $player = getDataForPlayerID($playerID, $seasonID);
            array_push($this->allPlayers, $player);
        }
    }

    public function getPlayerWithID($playerID) {
        for ($i = 0; $i < count($this->allPlayers); $i++) {
            if ($this->allPlayers[$i]->id == $playerID) { return $this->allPlayers[$i]; }
        }
        return null;
    }

    public function getPositionForPlayerWithID($playerID) {
        usort($this->allPlayers, "sortByPointsThenMatchPercentage");
        for ($i = 0; $i < count($this->allPlayers); $i++) {
            if ($this->allPlayers[$i]->id == $playerID) { return $i + 1; }
        }
        return null;
    }
}