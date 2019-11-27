
<?php
session_start();

// Include config file
require_once "config.php";

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit();
	}


  //new code
$user_id = empty($_SESSION['username']) ? '' : $_SESSION['username'];

  if(isset($_POST['submit'])){

    $comment = $_POST['comment'];

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

               header("location: comment.php?comment=success");
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
  <meta charset="UTF-8">
  <title>Comments</title>
  <link rel="stylesheet" type="text/css" href="style.css"></link>
</head>
<body>
	<?php include 'header.php';?>
  <form method="POST" action="comment.php">
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
<?php include 'footer.php' ;?>
</body>
</html>
