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

  if (isset($_POST['liked'])){
    $post_id = $_POST['postid'];

    $sql = "SELECT * FROM uploads WHERE id = $post_id";

    if(!$stmt = $pdo->prepare($sql)){
        echo "SQL statement failed";
    }else{
      $stmt->execute();
      while($row = $stmt->fetch()){
        $n = $row['likes'];

      }
    }

    $sql = "INSERT INTO likes (postid) VALUES (?)";
    if(!$stmt = $pdo->prepare($sql)){
        echo "SQL statement failed";
    }else{
      $stmt->execute([$post_id]);
    }

      $sql = "UPDATE uploads SET likes= $n+1 WHERE id=$post_id";
      if(!$stmt = $pdo->prepare($sql)){
          echo "SQL statement failed";
      }else{
        $stmt->execute([$post_id]);
      }

      echo $n+1;
      header("location: gallery.php");
  }

  if (isset($_POST['unliked'])){
    $post_id = $_POST['postid'];

    $sql = "SELECT * FROM uploads WHERE id = $post_id";

    if(!$stmt = $pdo->prepare($sql)){
        echo "SQL statement failed";
    }else{
      $stmt->execute();
      while($row = $stmt->fetch()){
        $n = $row['likes'];

      }
    }

    $sql = "DELETE FROM likes WHERE postid = $post_id";
    if(!$stmt = $pdo->prepare($sql)){
        echo "SQL statement failed";
    }else{
      $stmt->execute([$post_id]);
    }

      $sql = "UPDATE uploads SET likes= $n-1 WHERE id = $post_id";
      if(!$stmt = $pdo->prepare($sql)){
          echo "SQL statement failed";
      }else{
        $stmt->execute([$post_id]);
      }

      echo $n-1;
      header("location: gallery.php");

  }

?>
