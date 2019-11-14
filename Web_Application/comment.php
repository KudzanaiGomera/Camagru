
<?php
require_once "gallery.php";
require_once "config.php";
include 'comment.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Comments</title>
  <link rel="stylesheet" type="text/css" href="style.css"></link>
</head>
<body>
  <?php
  echo "<form method='POST' action='".setComment()."'>
    <input type='hidden' name='user_id' value='Anonymous'>
    <textarea name='Comment'></textarea><br>
    <button type= 'submit' name= 'commentSubmit'>Comment</button>
  </form>";
  ?>
</body>
</html>
