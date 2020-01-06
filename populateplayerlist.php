<?php

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'spencer';   // ...variables according
$dbpass  = 'salute';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

$sql = mysqli_query($connection, "SELECT player_name FROM players ORDER BY player_name");
while ($row = $sql->fetch_assoc()){
  echo "<option value= \"" . $row['player_name'] . "\">" . $row['player_name'] . "</option>";
}

echo "<a href = 'index.php'>Back to Home</a>";

?>
