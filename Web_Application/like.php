<?php
// setting up connection
require_once "config.php";

//session start
if(session_status() == PHP_SESSION_NONE){
  session_start();
}


//error handling
// ini_set('display_errors', 1);
// 	ini_set('display_startup_errors', 1);
// 	error_reporting(E_ALL);
//
// $user_id = $_SESSION['id'];
// $post_id = $_GET['id'];
//
// $sql = "SELECT * FROM uploads WHERE post_id = $post_id";
// if(!$stmt = $pdo->prepare($sql)){
//     echo "SQL statement failed";
// }else{
//   $stmt->execute();
//   while($row = $stmt->fetch()){
//     $post_id = $row['id'];
//   }
// }
//
//   try {
//       $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id, action) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE");
//       $stmt->execute([$post_id, $user_id]);
//     } catch (\PDOException $e) {
//       if ((int) $e->getCode() === 23000){
//        $stm2 = $db_conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
//        $stm2->execute([$post_id, $user_id]);
//     }else {
//         $error = true;
//     }
//   }
// ?>
<!--
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
</html> -->
