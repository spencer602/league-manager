<?php
include_once 'sqlscripts.php';
include_once 'player.php';
include_once 'guihelperfunctions.php';
include_once 'match.php';

function sortByPointsThenMatchPercentage($a, $b) {
    if ($a->points == $b->points){
        if ($a->getWinPercentage() == $b->getWinPercentage()) {
            return 0;
        }
        return ($a->getWinPercentage() < $b->getWinPercentage()) ? 1 : -1;
    }
    return ($a->points < $b->points) ? 1 : -1;
}

function sortByNameAlphabetical($a, $b) {
    if ($a->name == $b->name) { return 0; }
    return ($a->name < $b->name) ? -1 : 1;
}

class LeagueManager
{
    public $allPlayers = array();

    static function getLocationList()
    {
        $locations = array();

        $locationQuery = queryDB("SELECT location_name FROM locations");
        while ($row = $locationQuery->fetch_assoc()) {
            array_push($locations, $row['location_name']);
        }
        return $locations;
    }

    static function getPlayerNameFromID($id) {
        $data = queryDB("SELECT player_name FROM players WHERE player_id = '$id';");
        $player = $data->fetch_array(MYSQLI_ASSOC);
        return $player['player_name'];
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
            $player = self::getDataForPlayerID($playerID, $seasonID);
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

    public static function getTournamentResultsFor($tourneyID) {
        $tourneyData = queryDB("SELECT * FROM tournament_results WHERE tournament_id = '$tourneyID' ORDER BY position;");
        $tourneyResults = array();
        while ($row = $tourneyData->fetch_assoc()) {
            $id = $row['player_id'];
            $name = LeagueManager::getPlayerNameFromID($row['player_id']);
            $result = $row['position'];
            $points = $row['points'];
            array_push($tourneyResults, [$name, $result, $points, $id]);
        }
        return $tourneyResults;
    }

    public function getAllNamesInAlphabeticalOrder() {
        $allNames = array();

        usort($this->allPlayers, "sortByNameAlphabetical");
        for ($i = 0; $i < count($this->allPlayers); $i++) {
            array_push($allNames, $this->allPlayers[$i]->name);
        }
        return $allNames;
    }

    static function getAllTourneyMatchIDsForSeason($seasonID) {
        $query = "SELECT match_id FROM tournaments, tournament_matches WHERE tournaments.tournament_id = tournament_matches.tournament_id AND
            tournaments.season_id = '$seasonID';";

        $tourneyMatches = queryDB($query);
        $allMatchIDs = array();

        while ($row = $tourneyMatches->fetch_assoc()) {
            array_push($allMatchIDs, $row['match_id']);
        }

        return $allMatchIDs;
    }

    static function getDataForPlayerID($playerID, $seasonID) {

        // all fields of all matching queries
        $query = "SELECT p1.player_name AS p1name, p2.player_name AS p2name, p1_points_wagered, p2_points_wagered, 
    p1_games_needed, p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time, location_played, p1_id, p2_id, match_id 
            FROM players p1, matches, players p2 
            WHERE p1.player_id = p1_id AND p2.player_id = p2_id AND (p1_id = '$playerID' OR p2_id = '$playerID') AND season = '$seasonID'
            ORDER BY date_and_time DESC;";
        $allMatches = queryDB($query);
        $playerPoints = 0;
        $rank = -100;
        $playerMatchWins = 0;
        $playerMatches = 0;
        $playerGameWins = 0;
        $playerGames = 0;
        $playerEROs = 0;
        $names = queryDB("SELECT * FROM players WHERE player_id = '$playerID'");
        $playerName = "Empty, error";
        $phoneNumber = "";

        $listOfTourneyMatchIDs = self::getAllTourneyMatchIDsForSeason($seasonID);

        while ($row = $names->fetch_assoc()) {
            $playerName = $row['player_name'];
            $rank = $row['rank'];
            $phoneNumber = $row['phone'];

        }

        while ($row = $allMatches->fetch_assoc()) {
            $matchID = $row['match_id'];

            $isTourneyMatch = false;
            if (in_array($matchID, $listOfTourneyMatchIDs)) { $isTourneyMatch = true; }

            $p1points = 0;
            $p2points = 0;

            $p1MatchWins = 0;
            $p2MatchWins = 0;

            if (!$isTourneyMatch) { $playerMatches += 1; }
            $playerGames += $row['p1_games_won'] + $row['p2_games_won'];

            $p1IsWinner = false;
            // determines the winner
            if ($row['p1_games_won'] == $row['p1_games_needed']) {
                $p1IsWinner = true;
            }

            // update the stats based on winner: assigning points (even if there is a point handicap given)
            // NOTE: if p1 is winner, then the number of points won/lost by each is determined by how much player2 wagered
            if ($p1IsWinner) {
                $p1points += $row['p2_points_wagered'];
                $p2points -= $row['p2_points_wagered'];
                if (!$isTourneyMatch) { $p1MatchWins += 1; }
            } else {    // NOTE: if p2 is winner, then the number of points won/lost by each is determined by how much player1 wagered
                $p1points -= $row['p1_points_wagered'];
                $p2points += $row['p1_points_wagered'];
                if (!$isTourneyMatch) { $p2MatchWins += 1; }
            }

            if ($row['p1_id'] == $playerID) {
                if (!$isTourneyMatch) { $playerPoints += $p1points; }
                if (!$isTourneyMatch) { $playerMatchWins += $p1MatchWins; }
                $playerGameWins += $row['p1_games_won'];
                $playerEROs += $row['p1_ero'];
            }
            else if ($row['p2_id'] == $playerID) {
                if (!$isTourneyMatch) { $playerPoints += $p2points; }
                if (!$isTourneyMatch) { $playerMatchWins += $p2MatchWins; }
                $playerGameWins += $row['p2_games_won'];
                $playerEROs += $row['p2_ero'];
            }
        }

        $query = "SELECT points FROM tournament_results, tournaments 
        WHERE player_id = '$playerID' AND tournaments.tournament_id = tournament_results.tournament_id AND 
        tournaments.season_id = $seasonID;";

        $tourneyResults = queryDB($query);

        while ($row = $tourneyResults->fetch_assoc()) {
            $tourneyPoints = $row['points'];
            $playerMatches += 1;
            $playerMatchWins += $tourneyPoints > 0 ? 1 : 0;
            $playerPoints += $tourneyPoints;
        }

        return new Player($playerID, $playerName, $rank, $playerPoints, $playerGames, $playerGameWins, $playerMatches, $playerMatchWins, $playerEROs, $phoneNumber);
    }

    static function getAllMatchesFor($seasonID, $playerID, $tourneyID)
    {
        // all fields of all matching queries
        $query = "";
        if ($tourneyID != null) {
            $query = "SELECT * FROM matches, tournament_matches WHERE matches.match_id = tournament_matches.match_id AND tournament_id = '$tourneyID' ORDER BY round;";
        }
        else if ($playerID == null) {
            $query = "SELECT * from matches WHERE season = $seasonID ORDER BY date_and_time DESC;";
        } else {
            $query = "SELECT * from matches WHERE season = $seasonID AND (p1_id = '$playerID' OR p2_id = '$playerID') ORDER BY date_and_time DESC;";
        }
        $allMatches = queryDB($query);

        //$tourneyMatchIDs = getAllTourneyMatchIDsForSeason(2);
//        $tourneyIDsThatHaveBeenDisplayed = array();

        $allMatchesArray = array();

        while ($row = $allMatches->fetch_assoc()) {
            $match = new Match($row['p1_id'], $row['p2_id'], $row['location_played'], $row['season'], $row['p1_games_needed'],
               $row['p1_games_won'], $row['p1_ero'], $row['p2_games_needed'], $row['p2_games_won'], $row['p2_ero'], $row['p1_rank'],
               $row['p2_rank'], $row['date_and_time'], $row['match_id'], $row['paid'], $row['p1_points_wagered'], $row['p2_points_wagered'], $row['round']);

            array_push($allMatchesArray, $match);
        }
        return $allMatchesArray;
    }
}