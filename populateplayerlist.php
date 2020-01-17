<?php

include_once 'sqlscripts.php';

$sql = queryDB("SELECT player_name FROM players ORDER BY player_name");
while ($row = $sql->fetch_assoc()){
  echo "<option value= \"" . $row['player_name'] . "\">" . $row['player_name'] . "</option>";
}

//echo "<a href = 'index.php'>Back to Home</a>";

?>
