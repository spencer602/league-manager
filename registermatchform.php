<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register A Match</title>
	<link rel="stylesheet" href="css/styles.css">


  </head>
  <script src="registermatch.js"></script>
  <body onload="bodyLoaded()">
	<div id="wrapper">
		<h1>Pool League Management Tool</h1>
		<div id="p1">
			<form action="registermatch.php" method="post">

			  <h3>Player One:</h3>


        <input list = "playerOne" name = "player1" id = "player1">
			  <datalist id = "playerOne">
          <?php include 'populateplayerlist.php';?>
			  </datalist>
			  <br><br>

			  <label id = "playerOneGamesLabel">Games to win: 5</label>
			  <input type = "range" min = "5" max = "9" name = "playerOneGamesInput" id = "playerOneGamesInput" value = "5">
			  <br><br>

			  <label id = "playerOnePointsLabel">Points to wager: 10</label>
			  <input type = "range" min = "10" max = "25" step = "5" name = "playerOnePointsInput" id = "playerOnePointsInput" value = "10">
			  <br><br>

			  <label id = "playerOneGamesWonLabel">Games won: 0</label>
			  <input type = "range" min = "0" max = "9" name = "playerOneGamesWonInput" id = "playerOneGamesWonInput" value = "0">
		  </div>
		  <div id="p2">
		  <h3>Player Two:</h3>

		  <input list = "playerTwo" id = "player2" name = "player2">

		  <datalist id = "playerTwo">
        <?php include 'populateplayerlist.php';?>
		  </datalist>
		  <br><br>

		  <label id = "playerTwoGamesLabel">Games to win: 5</label>
		  <input type = "range" min = "5" max = "9" name = "playerTwoGamesInput" id = "playerTwoGamesInput" value = "5">
		  <br><br>

		  <label id = "playerTwoPointsLabel">Points to wager: 10</label>
		  <input type = "range" min = "10" max = "25" step = "5" name = "playerTwoPointsInput" id = "playerTwoPointsInput" value = "10">
		  <br><br>

		  <label id = "playerTwoGamesWonLabel">Games won: 0</label>
		  <input type = "range" min = "0" max = "9" name = "playerTwoGamesWonInput" id = "playerTwoGamesWonInput" value = "0">
		  <br><br><br><br>
		  </div>
			<div id="loc">
		  Location<br>
		  <input list = "location" id = "locationPlayed" name = "locationPlayed">

		  <datalist id = "location">
              <?php include 'populatelocationlist.php';?>


          </datalist>
		  <br><br><br>

		  <label id = "playerOnePasswordLabel">Player One password:</label>
		  <input type = "password" name = "playerOnePassword" id = "playerOnePassword">
		  <br><br>

		  <label id = "playerTwoPasswordLabel">Player Two password:</label>
		  <input type = "password" name = "playerTwoPassword" id = "playerTwoPassword">
		  <br><br><br>

		  <input type = "submit">

		</form>
	</div>
  </body>

  </html>
