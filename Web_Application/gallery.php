
<?php
// Initialize the session
session_start();

//Report all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
</head>
<body>
  <main>

    <section class="gallery-links">
      <div class="wrapper">
        <h2>Gallery</h2>
        <div class="gallery-container">
          <?php
          require_once "upload.php";
          $sql = "SELECT * FROM uploads ORDER BY created_at DESC";
          //preparing the statement
          if(!$stmt = $pdo->prepare($sql)){
              echo "SQL statement failed";
          }else{
            $stmt->execute();
            while($row = $stmt->fetch()){
              echo '<a href="#">
                <div style="background-image:url(images/gallery/'.$row["imageFullName"].');">
                <div>
                <div>
                <span class="glyphicon glyphicon-like" aria-hidden="true"></span>
                <span><strong style="margin-left: -150px; margin-top:80px;">Like</strong></span>
                </div>
                <div>
                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                <span><strong style="margin-right: -150px;">Comment</strong></span>
                </div>
                </div>
                </div>
              </a>';
            };
          }
          ?>
        </div>
      </div>
    <section>

  </main>
</body>
</html>
