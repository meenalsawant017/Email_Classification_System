<?php

//error reporting and warning display.
error_reporting(E_ALL);
ini_set('display_errors', 'On');

if (!ini_get('date.timezone')) {
	date_default_timezone_set('GMT');
	date_default_timezone_set('US/Eastern');
}


require_once("db-settings.php"); //Require DB connection
require_once("functions.php"); // database and other functions are written in this file
require_once("class.user.php");

session_start();
//echo session_id();

//loggedInUser can be used globally if constructed
global $loggedInUser;
if(isset($_SESSION["ThisUser"]) && is_object($_SESSION["ThisUser"]))
{
	 $loggedInUser = $_SESSION["ThisUser"];
}


//echo "SESSION VARIABLES ";
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
//echo "LOGGED IN USER DETAILS";
//echo "<pre>";
//print_r($loggedInUser);
//echo "</pre>";

?>
