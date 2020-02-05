<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>
    <script src="registermatch2020.js"></script>
    <script src="inputBoxChange.js"></script>

    <?php
    include_once 'LeagueManager.php';
    require 'header.php';
    echo "<link rel=\"stylesheet\" href=\"css/registermatchform.css\">";
    echo "<body onload = 'bodyLoaded()'>";
    echo "<script>setTitle('Register Match')</script>";
    echo "<script>setCurrentPage('Register Match')</script>";
    $leagueManager = new LeagueManager();
    $leagueManager->updateForSeason(2);
    ?>

    <div id="container">
        <form action = "registermatch.php" method = "post" onsubmit="return validateForm()">
            <div id="p1">
                <h3>Player One:</h3>
                <select id = "player1" name="player1" class = "input">
                    <option value="none" selected disabled hidden>Select Player 1</option>
                    <?php
                    $playerNames = $leagueManager->getAllNamesInAlphabeticalOrder();
                    for ($i = 0; $i < count($playerNames); $i++) {
                        echo "<option value= \"" . $playerNames[$i] . "\">" . $playerNames[$i] . "</option>";
                    }
                    ?>
                </select>
                <br><br>
<!--                <label id = "playerOneGamesLabel" class = "inputLabel">Games to win: 5</label><br>-->
<!--                <input type = "range" min = "5" max = "9" name = "playerOneGamesInput" id = "playerOneGamesInput"  class = "input"value = "5">-->
<!--                <br><br>-->
<!--                <label id = "playerOnePointsLabel" class = "inputLabel">Points to wager: 10</label><br>-->
<!--                <input type = "range" min = "10" max = "25" step = "5" name = "playerOnePointsInput" id = "playerOnePointsInput"  class = "input"value = "10">-->
<!--                <br><br>-->
                <label id = "playerOneGamesWonLabel" class = "inputLabel">Games won: 0</label><br>
                <input type = "range" min = "0" max = "7" name = "playerOneGamesWonInput" id = "playerOneGamesWonInput"  class = "input"value = "0">
                <br><BR>
                <label id = "playerOneEROLabel" class = "inputLabel">EROs: 0</label><Br>
                <input type = "range" min = "0" max = "7" name = "playerOneEROInput" id = "playerOneEROInput"  class = "input"value = "0">


            </div>
            <div id="p2">
                <h3>Player Two:</h3>
                <select id = "player2" name="player2" class = "input">
                    <option value="none" selected disabled hidden>Select Player 2</option>
                    <?php
                    for ($i = 0; $i < count($playerNames); $i++) {
                        echo "<option value= \"" . $playerNames[$i] . "\">" . $playerNames[$i] . "</option>";
                    }
                    ?>
                </select>
                <br><br>
<!--                <label id = "playerTwoGamesLabel" class = "inputLabel">Games to win: 5</label><br>-->
<!--                <input type = "range" min = "5" max = "9" name = "playerTwoGamesInput" id = "playerTwoGamesInput" class = "input" value = "5">-->
<!--                <br><br>-->
<!--                <label id = "playerTwoPointsLabel" class = "inputLabel">Points to wager: 10</label><br>-->
<!--                <input type = "range" min = "10" max = "25" step = "5" name = "playerTwoPointsInput" id = "playerTwoPointsInput" class = "input" value = "10">-->
<!--                <br><br>-->
                <label id = "playerTwoGamesWonLabel" class = "inputLabel">Games won: 0</label><br>
                <input type = "range" min = "0" max = "7" name = "playerTwoGamesWonInput" id = "playerTwoGamesWonInput" class = "input" value = "0">
                <br><br>

                <label id = "playerTwoEROLabel" class = "inputLabel">EROs: 0</label><br>
                <input type = "range" min = "0" max = "7" name = "playerTwoEROInput" id = "playerTwoEROInput" class = "input" value = "0">

                <br><br>

            </div>
            <div class="spacer"></div>
            <div id="loc">
                <h3>Location:</h3>
                <select id = "locationPlayed" name= "locationPlayed" class = "input">
                    <?php
                    $locations = $leagueManager::getLocationList();
                    for ($i = 0; $i < count($locations); $i++) {
                        echo "<option value= \"" . $locations[$i] . "\">" . $locations[$i] . "</option>";
                    }
                    ?>
                </select>
            </div><br>
            <div id="passwords">
                <label id = "playerOnePasswordLabel">Player One Password:</label><br>
                <input type = "password" name = "playerOnePassword" id = "playerOnePassword" class = "input" oninput='inputBoxChange("playerOnePassword")'>
                <br><br>
                <label id = "playerTwoPasswordLabel">Player Two Password:</label><br>
                <input type = "password" name = "playerTwoPassword" id = "playerTwoPassword" class = "input" oninput='inputBoxChange("playerTwoPassword")'>
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