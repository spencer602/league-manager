<?php
include_once 'player.php';
include_once 'sqlscripts.php';
include_once 'helperfunctions.php';



function getPlayerPosition($playerID, $seasonID) {
    $thisPlayer = getDataForPlayerID($playerID, $seasonID);
    $query = "SELECT player_id FROM registrations WHERE season_id = '$seasonID';";
    $players = queryDB($query);
    $allPlayers = array();
    while ($player = $players->fetch_assoc()) {
        $newPlayer = getDataForPlayerID($player['player_id'], $seasonID);
        array_push($allPlayers, $newPlayer);
    }
    usort($allPlayers, "sortByPoints");

    for ($i = 0; $i < count($allPlayers); $i++) {
        if ($allPlayers[$i]->id == $thisPlayer->id ) { return $i + 1; }
    }

    return -1;
}

function getDataForPlayerID($playerID, $seasonID) {

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

    $listOfTourneyMatchIDs = getAllTourneyMatchIDsForSeason($seasonID);

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

function getWinPercentageGreaterThan($winPercentageThreshold, $playerID) {

// all fields of all matching queries
    $query = "SELECT p1.player_name AS p1name, p2.player_name AS p2name, p1_points_wagered, p2_points_wagered, 
    p1_games_needed, p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time, location_played, p1_id, p2_id 
            FROM players p1, matches, players p2 
            WHERE p1.player_id = p1_id AND p2.player_id = p2_id AND (p1_id = '$playerID' OR p2_id = '$playerID')
            ORDER BY date_and_time DESC;";
    $allMatches = queryDB($query);

    $playerGameWins = 0;
    $playerGames = 0;

    while ($row = $allMatches->fetch_assoc()) {
        $opponentID = $row['p1_id'];
        if ($playerID == $opponentID) $opponentID = $row['p2_id'];
        $opponentData = getDataForPlayerID($opponentID);
        $opponentWinPercentage = $opponentData[3] / $opponentData[4];
        if ($opponentWinPercentage > $winPercentageThreshold) {
            $playerGames += $row['p1_games_won'] + $row['p2_games_won'];
            if ($playerID == $row['p1_id']) $playerGameWins += $row['p1_games_won'];
            if ($playerID == $row['p2_id']) $playerGameWins += $row['p2_games_won'];
        }
    }

    if ($playerGames == 0) return "NA";
    return $playerGameWins / $playerGames;
}




