<?php


session_start();

if ($_SESSION['adminLoggedIn'] != 1) {
    header("location: adminloginform.php");
}

include_once "sqlscripts.php";



echo'test';