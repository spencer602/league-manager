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

    public function addMatch($p1name, $p2name, $p1gamesWon, $p2gamesWon, $p1ero, $p2ero, $locationName, $p1password, $p2password, $seasonID) {
        $p1gamesToWin = 7;
        $p2gamesToWin = 7;

        $p1pointsWagered = 15;
        $p2pointsWagered = 15;

        // queries the player table
        $p1Row = queryDB("SELECT * FROM players WHERE player_name = '$p1name';");
        $p1Row = $p1Row->fetch_array(MYSQLI_ASSOC);
        $p1ID = $p1Row['player_id'];
        $p1Hash = $p1Row['password'];
        $p1Rank = $p1Row['rank'];

        $p2Row = queryDB("SELECT * FROM players WHERE player_name= '$p2name';");
        $p2Row = $p2Row->fetch_array(MYSQLI_ASSOC);
        $p2ID = $p2Row['player_id'];
        $p2Hash = $p2Row['password'];
        $p2Rank = $p2Row['rank'];

        $defaultPaidNo = 0;

        session_start();

        if ($_SESSION['adminLoggedIn'] != 1) {
            if (!password_verify($p1password, $p1Hash)) { die("Invalid Password for $p1name"); }
            if (!password_verify($p2password, $p2Hash)) { die("Invalid Password for $p2name"); }
        }

        if ($p1Rank <= $p2Rank) {
            $p1gamesToWin = 7;
            $p2gamesToWin = 7 - ($p2Rank - $p1Rank);
        } else {
            $p2gamesToWin = 7;
            $p1gamesToWin = 7 - ($p1Rank - $p2Rank);
        }

        // gets the location data from the locationName via the 'locations' table
        $locationRow = queryDB("SELECT * FROM locations WHERE location_name = '$locationName'");
        $locationRow = $locationRow->fetch_array(MYSQLI_ASSOC);
        $locationID = $locationRow['location_id'];

        // the query we are using for inserting the match into the table
        $insertQueryString = "INSERT INTO matches
            (p1_id, p2_id, p1_points_wagered, p2_points_wagered, p1_games_needed,
            p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time,
            location_played, paid, season, p1_rank, p2_rank)
            VALUES
            ($p1ID, $p2ID, $p1pointsWagered, $p2pointsWagered, $p1gamesToWin, $p2gamesToWin, $p1gamesWon, $p2gamesWon,
            $p1ero, $p2ero, NOW(), $locationID, $defaultPaidNo, $seasonID, $p1Rank, $p2Rank);";

        // send the query to the database
        queryDB($insertQueryString);

        $data = queryDB("SELECT match_id FROM matches ORDER BY match_id DESC;");
        $row = $data->fetch_assoc();
        $matchID = $row['match_id'];
        return $matchID;
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

    public function getAllPlayerData() {
        return $this->allPlayers;
    }
}