<?php
// setting up connection
require_once "config.php";

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
$notification = "";

if($stmt = $pdo->prepare($sql = "SELECT * FROM notification WHERE user_id = $user_id")){
	$stmt->execute();

	while ($row= $stmt->fetch()){
		$notification = empty($row['action']) ? '':$row['action'];
	}
}

if(isset($_POST['notification']))
{
  if ($notification == 1)
  {
    $stm2 = $pdo->prepare("DELETE FROM notification WHERE user_id = ?");
    $stm2->execute([$user_id]);
    $message = 'You will not receive an email for notification';
  }
  else {
      $stmt = $pdo->prepare("INSERT INTO notification(user_id, action) VALUES (?, 1)");
      $stmt->execute([$user_id]);
      $message = 'You will receive an email';
    }

}
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Notification</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" type="text/css" href="style.css"></link>
</head>
<body>
<?php include 'header.php';?>
<h3><?php echo $message; ?></h3>
<?php

if($stmt = $pdo->prepare($sql = "SELECT * FROM notification WHERE user_id = $user_id")){
	$stmt->execute();

	while ($row= $stmt->fetch()){
		$notification = $row['action'];
	}
}
echo "notification value:" .$notification;
echo'<a href="comment.php?notification='.$notification.'">Back to comments</a>';
echo'<a href="gallery.php?notification='.$notification.'"><button type="button" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon"></span>Gallery</button></a>';

?>
<?php include 'footer.php' ;?>
</body>
</html>
