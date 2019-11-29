<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Register A Match</title>
	  <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/registermatchform.css">
   </head>
   <script src="registermatch.js"></script>
   <script src="inputBoxChange.js"></script>
   <div id="wrapper">
      <body onload="bodyLoaded()">
	  <div id ="header">
				<a href="index.php"><img src="images/logo.jpg" id="logo"></a>
		<div id="pageName">
         <h1>Big Sky</h1><br>
		 <h1>Shark Hunt</h1><br>
         <h1>Match Form</h1>
		 </div>
	  </div>
	  <div id="nav">
		 <ul id="navbar">
				<li><a href = "registermatchform.php">Register</a><br></li>
				<li><a href = "displayallmatches.php">History</a><br></li>
				<li><a href = "displaystandings.php">Standings</a></li>
		</ul>
	  </div>
         <div id="container">
            <form action = "registermatch.php" method = "post" onsubmit="return validateForm()">
			   <div id="p1">
                  <h3>Player One:</h3>
                  <select id = "player1" name="player1">
                     <?php include 'populateplayerlist.php';?>
                  </select>
                  <br><br>
                  <label id = "playerOneGamesLabel">Games to win: 5</label><br>
                  <input type = "range" min = "5" max = "9" name = "playerOneGamesInput" id = "playerOneGamesInput" value = "5">
                  <br><br>
                  <label id = "playerOnePointsLabel">Points to wager: 10</label><br>
                  <input type = "range" min = "10" max = "25" step = "5" name = "playerOnePointsInput" id = "playerOnePointsInput" value = "10">
                  <br><br>
                  <label id = "playerOneGamesWonLabel">Games won: 0</label><br>
                  <input type = "range" min = "0" max = "9" name = "playerOneGamesWonInput" id = "playerOneGamesWonInput" value = "0">
                    <br><BR>
                   <label id = "playerOneEROLabel">EROs: 0</label><Br>
                   <input type = "range" min = "0" max = "9" name = "playerOneEROInput" id = "playerOneEROInput" value = "0">


				</div>
            <div id="p2">
            <h3>Player Two:</h3>
            <select id = "player2" name="player2">
				<?php include 'populateplayerlist.php';?>
            </select>
            <br><br>
            <label id = "playerTwoGamesLabel">Games to win: 5</label><br>
            <input type = "range" min = "5" max = "9" name = "playerTwoGamesInput" id = "playerTwoGamesInput" value = "5">
            <br><br>
            <label id = "playerTwoPointsLabel">Points to wager: 10</label><br>
            <input type = "range" min = "10" max = "25" step = "5" name = "playerTwoPointsInput" id = "playerTwoPointsInput" value = "10">
            <br><br>
            <label id = "playerTwoGamesWonLabel">Games won: 0</label><br>
            <input type = "range" min = "0" max = "9" name = "playerTwoGamesWonInput" id = "playerTwoGamesWonInput" value = "0">
            <br><br>

                <label id = "playerTwoEROLabel">EROs: 0</label><br>
                <input type = "range" min = "0" max = "9" name = "playerTwoEROInput" id = "playerTwoEROInput" value = "0">

                <br><br>



            </div>
            <div class="spacer"></div>
            <div id="loc">
            <h3>Location:</h3>
            <select id = "locationPlayed" name= "locationPlayed">
				<?php include 'populatelocationlist.php';?>
            </select>
            </div><br>
            <div id="passwords">
            <label id = "playerOnePasswordLabel">Player One Password:</label><br>
            <input type = "password" name = "playerOnePassword" id = "playerOnePassword" oninput='inputBoxChange("playerOnePassword")'>
            <br><br>
            <label id = "playerTwoPasswordLabel">Player Two Password:</label><br>
            <input type = "password" name = "playerTwoPassword" id = "playerTwoPassword" oninput='inputBoxChange("playerTwoPassword")'>
            <br><br><br>
            </div>
            <div class="spacer"></div><br>
            <input type = "submit" id="subbut">
            </form>
			<br>
         </div>
		 <div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
      </body>
   </div>
</html>