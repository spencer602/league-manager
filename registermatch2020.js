var playerOneGamesWonInput;
var playerTwoGamesWonInput;

var playerOneInput;
var playerTwoInput;

var playerOneEROsInput;
var playerTwoEROsInput;

function validateForm() {
    if (!checkForPlayersNotSelected()) { return false; }
    if (!checkForNoWinner()) { return false; }
    if (!checkForTwoWinners()) { return false; }
    if (!checkForNamesEqual()) { return false; }
    if (!checkForValidERO()) { return false; }
}

function checkForValidERO() {
    if (playerOneEROsInput.value > playerOneGamesWonInput.value) {
        alert("Player One ERO count invalid");
        return false;
    }
    if (playerTwoEROsInput.value > playerTwoGamesWonInput.value) {
        alert("Player Two ERO count invalid");
        return false;
    }
    return true;
}

function checkForNamesEqual() {
    if (playerOneInput.value == playerTwoInput.value) {
        alert("Appears that you are playing with yourself???");
        return false;
    }
    return true;
}

function checkForNoWinner() {
    if (playerOneGamesWonInput.value != playerOneGamesWonInput.max && playerTwoGamesWonInput.value != playerTwoGamesWonInput.max) {
        alert("Appears that nobody won this match???");
        return false;
    }
    return true;
}

function checkForTwoWinners() {
    if (playerOneGamesWonInput.value == playerOneGamesWonInput.max && playerTwoGamesWonInput.value == playerTwoGamesWonInput.max) {
        alert("Appears that both of you won this match???");
        return false;
    }
    return true;
}

function checkForPlayersNotSelected() {
    if (playerOneInput.value == "none") {
        alert("Player 1 not selected");
        return false;
    }
    if (playerTwoInput.value == "none") {
        alert("Player 2 not selected");
        return false
    }
    return true;
}

function setRaces() {
    var playerOneName = document.getElementById("player1").value;
    var playerTwoName = document.getElementById("player2").value;

    if (playerOneName == "none" || playerTwoName == "none") { return; }

    var http = new XMLHttpRequest();
    var url = 'getplayerrank.php';
    var params = 'player_name=';
    params = params.concat(playerOneName);
    http.open('POST', url, false);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send(params);
    var playerOneRank = parseInt(http.responseText);

    params = 'player_name=';
    params = params.concat(playerTwoName);
    http.open('POST', url, false);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send(params);
    var playerTwoRank = parseInt(http.responseText);

    if (playerOneRank <= playerTwoRank) {
        // player one plays race to 7
        playerOneGamesWonInput.max = 7;
        playerTwoGamesWonInput.max = 7 - (playerTwoRank - playerOneRank);


    } else {
        // player two plays race to 7
        playerTwoGamesWonInput.max = 7;
        playerOneGamesWonInput.max = 7 - (playerOneRank - playerTwoRank);
    }

    changePlayerOneGamesWonLabel();
    changePlayerTwoGamesWonLabel();
    changePlayerOneEROLabel();
    changePlayerTwoEROLabel();
}

function bodyLoaded() {

    // playerOneEROsInput.max = 100;
    // player name inputs
    playerOneInput = document.getElementById("player1");
    playerOneInput.addEventListener("change", changePlayerOnePasswordName);
    playerOneInput.addEventListener("change", setRaces);

    playerTwoInput = document.getElementById("player2");
    playerTwoInput.addEventListener("change", changePlayerTwoPasswordName);
    playerTwoInput.addEventListener("change", setRaces);


    // games won
    playerOneGamesWonInput = document.getElementById("playerOneGamesWonInput");
    playerOneGamesWonInput.addEventListener("input", changePlayerOneGamesWonLabel);

    playerTwoGamesWonInput = document.getElementById("playerTwoGamesWonInput");
    playerTwoGamesWonInput.addEventListener("input", changePlayerTwoGamesWonLabel);

    // EROs
    playerOneEROsInput = document.getElementById("playerOneEROInput");
    playerOneEROsInput.addEventListener("input", changePlayerOneEROLabel);

    playerTwoEROsInput = document.getElementById("playerTwoEROInput");
    playerTwoEROsInput.addEventListener("input", changePlayerTwoEROLabel);

    changePlayerOneGamesWonLabel();
    changePlayerTwoGamesWonLabel();


}

function changePlayerOneEROLabel(event) {
    var playerOneEROLabel = document.getElementById("playerOneEROLabel");
    playerOneEROLabel.innerHTML = "EROs: " + playerOneEROsInput.value;
}

function changePlayerTwoEROLabel(event) {
    var playerTwoEROLabel = document.getElementById("playerTwoEROLabel");
    playerTwoEROLabel.innerHTML = "EROs: " + playerTwoEROsInput.value;
}

function changePlayerOneGamesWonLabel(event) {
    var playerOneGamesWonLabel = document.getElementById("playerOneGamesWonLabel");
    // playerOneEROsInput.max = playerOneGamesWonInput.value
    playerOneGamesWonLabel.innerHTML = "Games won: " + playerOneGamesWonInput.value + "/" + playerOneGamesWonInput.max;
    changePlayerOneEROLabel()
}

function changePlayerTwoGamesWonLabel(event) {
    var playerTwoGamesWonLabel = document.getElementById("playerTwoGamesWonLabel");
    // playerTwoEROsInput.max = playerTwoGamesWonInput.value
    playerTwoGamesWonLabel.innerHTML = "Games won: " + playerTwoGamesWonInput.value + "/" + playerTwoGamesWonInput.max;
    changePlayerTwoEROLabel()
}

function changePlayerOnePasswordName(event) {
    var playerNameForPassword = document.getElementById("playerOnePasswordLabel");
    playerNameForPassword.innerHTML = playerOneInput.value + "'s password:";
}

function changePlayerTwoPasswordName(event) {
    var playerNameForPassword = document.getElementById("playerTwoPasswordLabel");
    playerNameForPassword.innerHTML = playerTwoInput.value + "'s password:";
}