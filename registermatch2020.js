var playerOneGamesWonInput;
var playerTwoGamesWonInput;

var playerOneInput;
var playerTwoInput;

var playerOneEROsInput;
var playerTwoEROsInput;

function validateForm() {
    if (!checkForNoWinner()) {
        return false;
    }
    if (!checkForTwoWinners()) { return false; }
    if (!checkForNamesEqual()) { return false; }
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

function setRaces() {
    var http = new XMLHttpRequest();
    var url = 'getplayerrank.php';
    var playerName = document.getElementById("player1").value;
    var params = 'player_name=';
    params = params.concat(playerName);
    http.open('POST', url, false);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send(params);
    var playerOneRank = parseInt(http.responseText);

    playerName = document.getElementById("player2").value;
    params = 'player_name=';
    params = params.concat(playerName);
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
    playerOneEROsInput.max = playerOneGamesWonInput.value
    playerOneGamesWonLabel.innerHTML = "Games won: " + playerOneGamesWonInput.value + "/" + playerOneGamesWonInput.max;
    changePlayerOneEROLabel()
}

function changePlayerTwoGamesWonLabel(event) {
    var playerTwoGamesWonLabel = document.getElementById("playerTwoGamesWonLabel");
    playerTwoEROsInput.max = playerTwoGamesWonInput.value
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