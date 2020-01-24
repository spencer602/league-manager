<?php
include_once 'player.php';
include_once 'sqlscripts.php';

function getDataForPlayerID($playerID, $seasonID) {

    // all fields of all matching queries
    $query = "SELECT p1.player_name AS p1name, p2.player_name AS p2name, p1_points_wagered, p2_points_wagered, 
    p1_games_needed, p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time, location_played, p1_id, p2_id 
            FROM players p1, matches, players p2 
            WHERE p1.player_id = p1_id AND p2.player_id = p2_id AND (p1_id = '$playerID' OR p2_id = '$playerID') AND season = '$seasonID'
            ORDER BY date_and_time DESC;";
    $allMatches = queryDB($query);
    $playerPoints = 0;
    $playerMatchWins = 0;
    $playerMatches = 0;
    $playerGameWins = 0;
    $playerGames = 0;
    $playerEROs = 0;
    $names = queryDB("SELECT player_name FROM players WHERE player_id = '$playerID'");
    $playerName = "Empty, error";

    while ($row = $names->fetch_assoc()) {
        $playerName = $row['player_name'];
    }

    while ($row = $allMatches->fetch_assoc()) {

        $p1points = 0;
        $p2points = 0;

        $p1MatchWins = 0;
        $p2MatchWins = 0;

        $playerMatches += 1;
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
            $p1MatchWins += 1;
        } else {    // NOTE: if p2 is winner, then the number of points won/lost by each is determined by how much player1 wagered
            $p1points -= $row['p1_points_wagered'];
            $p2points += $row['p1_points_wagered'];
            $p2MatchWins += 1;
        }

        if ($row['p1_id'] == $playerID) {
            $playerPoints += $p1points;
            $playerMatchWins += $p1MatchWins;
            $playerGameWins += $row['p1_games_won'];
            $playerEROs += $row['p1_ero'];
        }
        else if ($row['p2_id'] == $playerID) {
            $playerPoints += $p2points;
            $playerMatchWins += $p2MatchWins;
            $playerGameWins += $row['p2_games_won'];
            $playerEROs += $row['p2_ero'];
        }
    }

    return new Player($playerID, $playerName, $playerPoints, $playerGames, $playerGameWins, $playerMatches, $playerMatchWins, $playerEROs);
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


