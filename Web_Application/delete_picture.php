<?php
require_once"config.php";
$deleteid= $_POST['user_id'];
$sql = "DELETE FROM comments WHERE user_id= '$deleteid']'";
if(!$stmt = $pdo->prepare($sql)){
    echo "SQL statement failed";
}else{
  $stmt->execute([$deleteid]);

   header("location: comment.php?comment=success");
}
?>
