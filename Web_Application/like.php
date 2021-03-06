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

$message = ' ';
$user_id = $_SESSION['id'];
$post_id = intval($_GET['post_id']);

  try {
      $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id, action) VALUES (?, ?, 1)");
      $stmt->execute([$user_id, $post_id]);
      $message = 'You have liked this photo';
    } catch (\PDOException $e) {
      if ((int) $e->getCode() === 23000){
       $stm2 = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
       $stm2->execute([$post_id, $user_id]);
       $message = 'You have disliked this photo';
    }else {
        $error = true;
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Likes</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="style.css"></link>
</head>
<body>
<?php include 'includes/header.php';?>
<h3><?php echo $message; ?></h3>
<?php header("location: gallery.php")?>
<?php include 'includes/footer.php' ;?>
</body>
</html>
