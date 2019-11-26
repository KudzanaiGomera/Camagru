<?php
// setting up connection
require_once "config.php";

//session start
if(session_status() == PHP_SESSION_NONE){
  session_start();
}


//error handling
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
  if (isset($_GET['like'])){
    $query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
    $statement = $pdo->prepare($query);
    $statement->execute(
      array(
       ':post_id'   => $_GET['post_id']
      )
    );
    $no_of_row = $statement->rowCount();
    if($no_of_row > 0)
    {
     $result = $statement->fetchAll();
     foreach($result as $row)
     {
         if($row['action'] == '0')
        {
         $update_query = "UPDATE likes SET action = 1 WHERE post_id = '".$row['post_id']."'";
         $statement = $pdo->prepare($update_query);
         $statement->execute();
         $sub_result = $statement->rowCount();
         if(isset($sub_result))
         {
          echo "post has been liked";
         }
        }
        else
        {
          $update_query = "UPDATE likes SET action = 0 WHERE post_id = '".$row['post_id']."'";
          $statement = $pdo->prepare($update_query);
          $statement->execute();
          $sub_result = $statement->rowCount();
          if(isset($sub_result))
          {
           echo "post has been disliked";
          }

        }
     }
    }
    else
    {
     echo "invalid action";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Likes</title>
  <link rel="stylesheet" type="text/css" href="style.css"></link>
</head>
<body>

  <form method="POST" action="like.php">
    <table>
    <tr><td colspan="2"><button type="submit" name="like" value="Like">Like</button></td><tr>
    </table>
  </form>

</body>
</html>
