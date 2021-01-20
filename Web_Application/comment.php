
<?php
session_start();

// Include config file
require_once "connection/config.php";

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: index.php");
	    exit();
	}


  //new code
$notification = empty($_GET['notification'])? '': $_GET['notification'];
$user_id = empty(($_SESSION['id']))? '': ($_SESSION['id']);
$post_id = empty(intval($_GET['post_id']))? '':intval($_GET['post_id']);


if($stmt = $pdo->prepare($sql = "SELECT * FROM uploads WHERE id = $post_id")){
	$stmt->execute();
	while ($row= $stmt->fetch()){
		$id = $row['user_id'];
	}
}

if($stmt = $pdo->prepare($sql = "SELECT * FROM users WHERE id = $id")){
	$stmt->execute();

	while ($row= $stmt->fetch()){
		$email = $row['email'];
	}
}


  if(isset($_POST['submit'])){

    $comment = htmlspecialchars(strip_tags(trim($_POST['comment'])));

    $sql = "SELECT * FROM comments";
    try {
        //preparing the statement
        if(!$stmt = $pdo->prepare($sql)){
            echo "SQL statement failed";
        }else{
          if($stmt->execute()){
            $sql = "INSERT INTO comments (user_id,comment) VALUES (?,?)";
            if(!$stmt = $pdo->prepare($sql)){
                echo "SQL statement failed";
            }else{
              $stmt->execute([$user_id,$comment]);

							//Send Email
							if($notification == 1){
								$to = $email;
								$subject = "Comment";
								$message =  "Someone commented on your post";
								$headers = "From: $user_id \r\n";
								$headers .= "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

								if (mail($to,$subject,$message,$headers))
								{
									echo ("success");
								}
								else {
									echo("Fail");
								}
							}

               header("location: gallery.php?");
            }
          }
        }
      } catch (PDOException $err) {
        echo "<br/><br />";
        print_r($err);
      }

    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Comments</title>
  <link rel="stylesheet" type="text/css" href="css/style.css"></link>
</head>
<body>
	<?php include 'includes/header.php';?>
  <form method="POST" action="">
    <table>
    <tr><td colspan="2">Comment: </td></tr>
    <tr><td colspan="2"><textarea name="comment"></textarea></td></tr>
    <tr><td colspan="2"><button type="submit" name="submit" value="Comment">Comment</button></td><tr>
    </table>
  </form>
  <?php
  $sql = "SELECT * FROM comments ORDER BY created_at DESC";
  //preparing the statement
  if(!$stmt = $pdo->prepare($sql)){
      echo "SQL statement failed";
  }else{
    $stmt->execute();
    while($row = $stmt->fetch()){
      $comment = $row['comment'];
			echo $user_id . '@: ';
			echo $comment . '<br />' . '<br />';
    }
  }
   ?>
<?php include 'includes/footer.php' ;?>
</body>
</html>
