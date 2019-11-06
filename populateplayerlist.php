<?php

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'user14';   // ...variables according
$dbpass  = '14rone';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

$sql = mysqli_query($connection, "SELECT name FROM player");
while ($row = $sql->fetch_assoc()){
  echo "<option value= \"" . $row['name'] . "\">";
}

?>
