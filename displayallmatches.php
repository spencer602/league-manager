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
				<li><a href = "index.php">Standings</a></li>
                <li><a href = "players.php">Players</a></li>

            </ul>
		</div>
		<br>
<?php

include_once 'sqlscripts.php';
include_once 'helperfunctions.php';

displayAllMatches(2, null);








?>
	<!--</table>-->

        <br><hr><br>

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>