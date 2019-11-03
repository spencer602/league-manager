<?php

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'user14';   // ...variables according
$dbpass  = '14rone';   // ...to your installation

echo "<option value = \"Spencer\">";

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");



function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2");
    return $result;
}

$q = "SELECT name from player;"
$result = queryMysql($q)
$num = $result->num_rows;

// echo "<option value = "Spencer">";

for ($j = 0 ; $j < 100 ; ++$j)
{
  echo "<option value = \"Spencer\">";

  $row = $result->fetch_array(MYSQLI_ASSOC);
  $v = $row['name'];
  // echo "<option value = \"" . $j . "\">";
  echo "<option value = " . $row['name'] . ">";

}


?>
