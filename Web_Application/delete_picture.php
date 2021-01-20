<?php
// setting up connection
require_once "connection/config.php";

//session start
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit();
}


// // error handling
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

$user_id = $_SESSION['id'];
$post_id = intval($_GET['post_id']);


$sql = "DELETE FROM likes WHERE post_id = '$post_id'";

$sql2 = "DELETE FROM uploads WHERE id = '$post_id'";

// deleting likes first so that we won't have foreign constrant error
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id]);
  } catch (\PDOException $e) {
      die("Cannot try" . $e->getMessage());
  }

// then delete the image
try {
  $stmt = $pdo->prepare($sql2);
  $stmt->execute([$post_id]);
  header("location: user_profile.php?delete=success");
} catch (\PDOException $e) {
    die("Cannot try" . $e->getMessage());
}
?>
