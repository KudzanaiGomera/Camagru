<?php
// setting up connection
require_once "config.php";

//session start
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit();
}


// // error handling
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

$user_id = $_SESSION['id'];
$post_id = intval($_GET['post_id']);

try {
    $stmt = $pdo->prepare("DELETE FROM uploads WHERE id = '$post_id'");
    $stmt->execute([$post_id]);
    header("location: user_profile.php?delete=success");
  } catch (\PDOException $e) {
      die("Cannot try" . $e->getMessage());
  }
?>
