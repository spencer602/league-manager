var playerOneGamesInput;
var playerTwoGamesInput;

var playerOnePointsInput;
var playerTwoPointsInput;

var playerOneGamesWonInput;
var playerTwoGamesWonInput;

var playerOneInput;
var playerTwoInput;

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
  playerTwoGamesWonLabel.innerHTML = "Games won: " + playerTwoGamesWonInput.value;

  // update games needed to win
  playerOneGamesInput.addEventListener("change", updatePlayerOneGamesNeededToWin)
  playerTwoGamesInput.addEventListener("change", updatePlayerTwoGamesNeededToWin)
  updatePlayerOneGamesNeededToWin(null);
  updatePlayerTwoGamesNeededToWin(null);

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
}

function changePlayerTwoGamesWonLabel(event) {
  var playerTwoGamesWonLabel = document.getElementById("playerTwoGamesWonLabel");
  playerTwoGamesWonLabel.innerHTML = "Games won: " + playerTwoGamesWonInput.value;
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
}

function updatePlayerTwoGamesNeededToWin(event) {
  playerTwoGamesWonInput.max = playerTwoGamesInput.value;
  changePlayerTwoGamesWonLabel(null);
}
