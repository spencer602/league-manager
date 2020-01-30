var sortForm;

function bodyLoaded() {
    sortForm = document.getElementById("sortForm");
}

function sortFormChanged() {
    sortForm.submit()
}

function reloadSortedPlayers() {
    sortedPlayersDiv.innerHTML = "<?php require 'sortplayers.php'; ?>";
}