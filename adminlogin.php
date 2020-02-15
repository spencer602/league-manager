<?php
include_once 'sqlscripts.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$passwordHash = queryDB("SELECT password FROM administrators WHERE name = '$username'");
$passwordHash = $passwordHash->fetch_array(MYSQLI_ASSOC)['password'];

$_SESSION['adminLoggedIn'] = password_verify($password, $passwordHash) ? $username : null;

//echo $_SESSION['adminLoggedIn'];

header("location: admin.php");

