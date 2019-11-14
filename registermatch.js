var playerOneGamesInput;
var playerTwoGamesInput;

var playerOnePointsInput;
var playerTwoPointsInput;

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
  if (playerOneGamesWonInput.value != playerOneGamesInput.value && playerTwoGamesWonInput.value != playerTwoGamesInput.value) {
    alert("Appears that nobody won this match???");
    return false;
  }
  return true;
}

function checkForTwoWinners() {
  if (playerOneGamesWonInput.value == playerOneGamesInput.value && playerTwoGamesWonInput.value == playerTwoGamesInput.value) {
    alert("Appears that both of you won this match???");
    return false;
  }
  return true;
}


function bodyLoaded() {
  // player name inputs
  playerOneInput = document.getElementById("player1");
  playerOneInput.addEventListener("change", changePlayerOnePasswordName);

  playerTwoInput = document.getElementById("player2");
  playerTwoInput.addEventListener("change", changePlayerTwoPasswordName);

  // Games To Win
  playerOneGamesInput = document.getElementById("playerOneGamesInput");
  playerOneGamesInput.addEventListener("input", changePlayerOneGamesLabel);
  playerOneGamesLabel.innerHTML = "Games to win: " + playerOneGamesInput.value;

  playerTwoGamesInput = document.getElementById("playerTwoGamesInput");
  playerTwoGamesInput.addEventListener("input", changePlayerTwoGamesLabel);
  playerTwoGamesLabel.innerHTML = "Games to win: " + playerTwoGamesInput.value;

  // Points wagered
  playerOnePointsInput = document.getElementById("playerOnePointsInput");
  playerOnePointsInput.addEventListener("input", changePlayerOnePointsLabel);
  playerOnePointsLabel.innerHTML = "Points to wager: " + playerOnePointsInput.value;

  playerTwoPointsInput = document.getElementById("playerTwoPointsInput");
  playerTwoPointsInput.addEventListener("input", changePlayerTwoPointsLabel);
  playerTwoPointsLabel.innerHTML = "Points to wager: " + playerTwoPointsInput.value;

  // games won
  playerOneGamesWonInput = document.getElementById("playerOneGamesWonInput");
  playerOneGamesWonInput.addEventListener("input", changePlayerOneGamesWonLabel);
  playerOneGamesWonLabel.innerHTML = "Games won: " + playerOneGamesWonInput.value;

  playerTwoGamesWonInput = document.getElementById("playerTwoGamesWonInput");
  playerTwoGamesWonInput.addEventListener("input", changePlayerTwoGamesWonLabel);

  // EROs
  playerOneEROsInput = document.getElementById("playerOneEROInput");
  playerOneEROsInput.addEventListener("input", changePlayerOneEROLabel);

  playerTwoEROsInput = document.getElementById("playerTwoEROInput");
  playerTwoEROsInput.addEventListener("input", changePlayerTwoEROLabel);

  // update games needed to win
  playerOneGamesInput.addEventListener("change", updatePlayerOneGamesNeededToWin)
  playerTwoGamesInput.addEventListener("change", updatePlayerTwoGamesNeededToWin)
  updatePlayerOneGamesNeededToWin(null);
  updatePlayerTwoGamesNeededToWin(null);

}

function changePlayerOneEROLabel(event) {
  var playerOneEROLabel = document.getElementById("playerOneEROLabel");
  playerOneEROLabel.innerHTML = "EROs: " + playerOneEROsInput.value;
}

function changePlayerTwoEROLabel(event) {
  var playerTwoEROLabel = document.getElementById("playerTwoEROLabel");
  playerTwoEROLabel.innerHTML = "EROs: " + playerTwoEROsInput.value;
}

function changePlayerOneGamesLabel(event) {
  var playerOneGamesLabel = document.getElementById("playerOneGamesLabel");
  playerOneGamesLabel.innerHTML = "Games to win: " + playerOneGamesInput.value;
}

function changePlayerTwoGamesLabel(event) {
  var playerTwoGamesLabel = document.getElementById("playerTwoGamesLabel");
  playerTwoGamesLabel.innerHTML = "Games to win: " + playerTwoGamesInput.value;
}

function changePlayerOnePointsLabel(event) {
  var playerOnePointsLabel = document.getElementById("playerOnePointsLabel");
  playerOnePointsLabel.innerHTML = "Points to wager: " + playerOnePointsInput.value;
}

function changePlayerTwoPointsLabel(event) {
  var playerTwoPointsLabel = document.getElementById("playerTwoPointsLabel");
  playerTwoPointsLabel.innerHTML = "Points to wager: " + playerTwoPointsInput.value;
}

function changePlayerOneGamesWonLabel(event) {
  var playerOneGamesWonLabel = document.getElementById("playerOneGamesWonLabel");
  playerOneGamesWonLabel.innerHTML = "Games won: " + playerOneGamesWonInput.value;
  playerOneEROsInput.max = playerOneGamesWonInput.value
  changePlayerOneEROLabel()
}

function changePlayerTwoGamesWonLabel(event) {
  var playerTwoGamesWonLabel = document.getElementById("playerTwoGamesWonLabel");
  playerTwoGamesWonLabel.innerHTML = "Games won: " + playerTwoGamesWonInput.value;
  playerTwoEROsInput.max = playerTwoGamesWonInput.value
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

function updatePlayerOneGamesNeededToWin(event) {
  playerOneGamesWonInput.max = playerOneGamesInput.value;
  changePlayerOneGamesWonLabel(null);
  playerOneEROsInput.max = playerOneGamesWonInput.value
  changePlayerOneEROLabel()
}

function updatePlayerTwoGamesNeededToWin(event) {
  playerTwoGamesWonInput.max = playerTwoGamesInput.value;
  changePlayerTwoGamesWonLabel(null);
  playerTwoEROsInput.max = playerTwoGamesWonInput.value
  changePlayerTwoEROLabel()
}
