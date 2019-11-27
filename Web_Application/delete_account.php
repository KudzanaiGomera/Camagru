<?php
 require_once "config.php";

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

// try {
//     $stmt = $pdo->prepare("DELETE FROM users WHERE id = '$user_id'");
//     $stmt->execute([$user_id]);
//     header("location: register.php?delete=success");
//   } catch (\PDOException $e) {
//       die("Cannot try" . $e->getMessage());
//   }

?>
