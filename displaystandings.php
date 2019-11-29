<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Current Standings</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/standings.css">
</head>
<div id="wrapper">
	<body>
		<div id="header">
			<div id="logo">
			<a href="index.php"><img src="images/logo.jpg" id="logo"></a><br>
			</div>
			<div id="pageName">
			<h1>Big Sky</h1><br>
			<h1>Shark Hunt</h1><br>
			<h1>Current Standings</h1>
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

$allStandings = mysqli_query($connection, "SELECT * from players ORDER BY points DESC");

// position is the players position in the rankings
$position = 0;
echo '<table id="standingsTable"><tr><th>Position</th><th>Points</th><th>Name</th><th>Matches</th><th>Games</th></tr>';
while ($row = $allStandings->fetch_assoc()) {
    $position++;
    $points = $row['points'];
    $name = $row['player_name'];
    $gamesWon = $row['games_won'];
    $gamesPlayed = $row['games_played'];
    $matchesWon = $row['matches_won'];
    $matchesPlayed = $row['matches_played'];

    // this could be updated to look better
    echo "<tr><td>$position</td><td>$points</td><td>$name</td><td>$matchesWon/$matchesPlayed</td><td>$gamesWon/$gamesPlayed</td></tr>";
    
}
echo "</table>";?>	

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>