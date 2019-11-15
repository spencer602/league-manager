<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Match History</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/index.css">
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

while ($row = $allMatches->fetch_assoc()) {
    $p1id = $row['p1_id'];
    $p2id = $row['p2_id'];

    $p1name = mysqli_query($connection, "SELECT player_name FROM players where player_id = '$p1id'");
    $p2name = mysqli_query($connection, "SELECT player_name FROM players where player_id = '$p2id'");

    $p1name = $p1name->fetch_array(MYSQLI_ASSOC);
    $p1name = $p1name['player_name'];

    $p2name = $p2name->fetch_array(MYSQLI_ASSOC);
    $p2name = $p2name['player_name'];

    $p1gamesToWin = $row['p1_games_needed'];
    $p2gamesToWin = $row['p2_games_needed'];

    $p1gamesWon = $row['p1_games_won'];
    $p2gamesWon = $row['p2_games_won'];

    $p1pointsWagered = $row['p1_points_wagered'];
    $p2pointsWagered = $row['p2_points_wagered'];

    // this could be updated to look better
    echo "<p>$p1name: $p1gamesWon/$p1gamesToWin vs $p2name: $p2gamesWon/$p2gamesToWin</p>";
}

echo "<a href = 'index.php'>Back to Home</a>";?>
		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>