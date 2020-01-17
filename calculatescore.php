<?php

function getDataForPlayerID($playerID) {
    $dbhost  = 'localhost';

    $dbname  = 'sharkhunt';   // Modify these...
    $dbuser  = 'spencer';   // ...variables according
    $dbpass  = 'salute';   // ...to your installation

    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($connection->connect_error)
        die("Fatal Error 1");

//$playerID = "5";

// all fields of all matching queries
    $query = "SELECT p1.player_name AS p1name, p2.player_name AS p2name, p1_points_wagered, p2_points_wagered, 
    p1_games_needed, p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time, location_played, p1_id, p2_id 
            FROM players p1, matches, players p2 
            WHERE p1.player_id = p1_id AND p2.player_id = p2_id AND (p1_id = '$playerID' OR p2_id = '$playerID')
            ORDER BY date_and_time DESC;";
    $allMatches = mysqli_query($connection, $query);

//    $resultArray = array();
//    $tempArray = array();
    $p2Array = array();

    $playerPoints = 0;
//    $opponentPoints = 0;
    $playerMatchWins = 0;
    $playerMatches = 0;
    $playerGameWins = 0;
    $playerGames = 0;
    $playerEROs = 0;
    $names = mysqli_query($connection, "SELECT player_name FROM players WHERE player_id = '$playerID'");
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

//    $name = $row['p2name'];
//
//    array_push($p2Array, $name);

        // Add each row into our results array
//    $tempArray = $row;
//    array_push($resultArray, $tempArray);
    }
//    $count = count($p2Array);
//    echo "21 points: $playerPoints";

//    return $playerPoints;

    $playerData = array($playerPoints, $playerMatchWins, $playerMatches, $playerGameWins, $playerGames, $playerEROs, $playerID, $playerName);

    return $playerData;
}

function getWinPercentageGreaterThan($winPercentageThreshold, $playerID) {
    $dbhost  = 'localhost';

    $dbname  = 'sharkhunt';   // Modify these...
    $dbuser  = 'spencer';   // ...variables according
    $dbpass  = 'salute';   // ...to your installation

    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($connection->connect_error)
        die("Fatal Error 1");

//$playerID = "5";

// all fields of all matching queries
    $query = "SELECT p1.player_name AS p1name, p2.player_name AS p2name, p1_points_wagered, p2_points_wagered, 
    p1_games_needed, p2_games_needed, p1_games_won, p2_games_won, p1_ero, p2_ero, date_and_time, location_played, p1_id, p2_id 
            FROM players p1, matches, players p2 
            WHERE p1.player_id = p1_id AND p2.player_id = p2_id AND (p1_id = '$playerID' OR p2_id = '$playerID')
            ORDER BY date_and_time DESC;";
    $allMatches = mysqli_query($connection, $query);

//    $resultArray = array();
//    $tempArray = array();
    $p2Array = array();

    $playerPoints = 0;
//    $opponentPoints = 0;
    $playerMatchWins = 0;
    $playerMatches = 0;
    $playerGameWins = 0;
    $playerGames = 0;
    $playerEROs = 0;


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


