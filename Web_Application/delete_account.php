<?php
 require_once "connection/config.php";

//session start
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

// // error handling
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

$user_id = $_SESSION['id'];
echo $user_id;

?>
