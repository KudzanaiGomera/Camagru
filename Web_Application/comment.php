
<?php
session_start();

// Include config file
require_once "config.php";

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

  //new code

  if(isset($_POST['submit'])){

    $comment = $_POST['comment'];

    $sql = "SELECT * FROM comments";
    try {
        //preparing the statement
        if(!$stmt = $pdo->prepare($sql)){
            echo "SQL statement failed";
        }else{
          if($stmt->execute()){
            $sql = "INSERT INTO comments (comment) VALUES (?)";
            if(!$stmt = $pdo->prepare($sql)){
                echo "SQL statement failed";
            }else{
              $stmt->execute([$comment]);

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
    //  $dellink="<a href=\"delete.php? user_id=" . $user_id . " \">Delete</a>";
      echo $comment . '<br />' . '<br />'; //.$dellink . '<br />';
    }
  }
   ?>
<?php include 'footer.php' ;?>
</body>
</html>
