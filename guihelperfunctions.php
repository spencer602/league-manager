<?php

function makeOptionsFromPlayerNames($playerNames) {
    for ($i = 0; $i < count($playerNames); $i++) {
        echo "<option value= \"" . $playerNames[$i] . "\">" . $playerNames[$i] . "</option>";
    }
}

function makeOptionsFromLocationNames($locations) {
    for ($i = 0; $i < count($locations); $i++) {
        echo "<option value= \"" . $locations[$i] . "\">" . $locations[$i] . "</option>";
    }
}

