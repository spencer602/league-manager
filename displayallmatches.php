<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Match History</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/matchhistory.css">
</head>

<div id="wrapper">
	<body>
		<div id="header">
			<div id ="logo">
			<a href="index.php"><img src="images/logo.jpg" id="logo"></a><br>
			</div>
			<div id="pageName">
			<h1>Big Sky</h1><br>
			<h1>Shark Hunt</h1><br>
			<h1>Match History</h1>
			</div>
		</div>
		<div id="nav">
			<ul id="navbar">
				<li><a href = "registermatchform.php">Register</a><br></li>
				<li><a href = "displayallmatches.php">History</a><br></li>
				<li><a href = "displaystandings.php">Standings</a></li>
			</ul>
		</div>
		<br>
<?php

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'spencer';   // ...variables according
$dbpass  = 'salute';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

// all fields of all matching queries
$allMatches = mysqli_query($connection, "SELECT * from matches ORDER BY date_and_time DESC");
//echo '<table id="matchTable"><tr><th>Player One</th><th>Points</th><th>Games Won</th><th>Player Two</th><th>Points</th><th>Games Won</th></tr>';
//echo "<h3 id='format'>Player | Points Wagered | Games Won</h3><br>";
while ($row = $allMatches->fetch_assoc()) {
    $p1id = $row['p1_id'];
    $p2id = $row['p2_id'];

    $p1name = mysqli_query($connection, "SELECT player_name FROM players where player_id = '$p1id'");
    $p2name = mysqli_query($connection, "SELECT player_name FROM players where player_id = '$p2id'");

    $p1name = $p1name->fetch_array(MYSQLI_ASSOC);
    $p1name = $p1name['player_name'];

    $p2name = $p2name->fetch_array(MYSQLI_ASSOC);
    $p2name = $p2name['player_name'];

    $p1gamesToWin = intval($row['p1_games_needed']);
    $p2gamesToWin = intval($row['p2_games_needed']);

    $p1gamesWon = intval($row['p1_games_won']);
    $p2gamesWon = intval($row['p2_games_won']);

    $p1pointsWagered = intval($row['p1_points_wagered']);
    $p2pointsWagered = intval($row['p2_points_wagered']);

    $p1ero = intval($row['p1_ero']);
    $p2ero = intval($row['p2_ero']);

    // 2019-11-29 12:03:32

    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_and_time']);
    $dateTimeString = $dateTime->format('D, M d, h:i A');

    $winner = "";
    $loser = "";

    if ($p1gamesWon == $p1gamesToWin) {
//        $winner = $p1name;
        $winner = "$p1name +$p2pointsWagered: $p1gamesWon/$p1gamesToWin";
        if ($p1ero > 0) {
            $winner = "$winner  ERO: $p1ero";
        }

//        $loser = $p2name;
        $loser = "$p2name -$p2pointsWagered: $p2gamesWon/$p2gamesToWin";
        if ($p2ero > 0) {
            $loser = "$loser  ERO: $p2ero";
        }
    } else {
//        $winner = $p2name;
        $winner = "$p2name +$p1pointsWagered: $p2gamesWon/$p2gamesToWin";
        if ($p2ero > 0) {
            $winner = "$winner  ERO: $p2ero";
        }
//        $loser = $p1name;
//
        $loser = "$p1name -$p1pointsWagered: $p1gamesWon/$p1gamesToWin";
        if ($p1ero > 0) {
            $loser = "$loser  ERO: $p1ero";
        }
    }

    // this could be updated to look better
	
    //echo "<tr><td>$p1name</td><td>$p1pointsWagered</td><td>$p1gamesWon/$p1gamesToWin</td></tr>";
	//echo "<tr><td>$p2name</td><td>$p2pointsWagered</td><td>$p2gamesWon/$p2gamesToWin</td></tr>";
	//echo "<div id='match'><span class='player'>$p1name</span><span class='points'> $p1pointsWagered</span>
    // <span class='wins'>$p1gamesWon/$p1gamesToWin<span><br><span id='versus'>VS.</span><br><span class='player'>$p2name</span>
    // <span class='points'>$p2pointsWagered</span> <span class='wins'>$p2gamesWon/$p2gamesToWin</span></div><hr>";

    echo "<span class = 'matchDiv'>
            <div class = 'dateTimeDiv'>$dateTimeString</div>
            <div class = 'winnerDiv'>$winner</div>
            <div class = 'loserDiv'>$loser</div><br><hr><br>
          </span>";

}?>
	<!--</table>-->
		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>