<?php

// Create connection

$dbhost  = 'localhost';

$dbname  = 'sharkhunt';   // Modify these...
$dbuser  = 'spencer';   // ...variables according
$dbpass  = 'salute';   // ...to your installation

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die("Fatal Error 1");

// all fields of all matching queries
$query = "SELECT location_name FROM locations";
$allLocations = mysqli_query($connection, $query);

$resultArray = array();
$tempArray = array();


while ($row = $allLocations->fetch_assoc()) {


    // Add each row into our results array
    $tempArray = $row;
    array_push($resultArray, $tempArray);
}

// Finally, encode the array to JSON and output the results
echo json_encode($resultArray);

// Close connections
mysqli_close($connection);