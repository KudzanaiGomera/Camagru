<?php
// Initialize the session
session_start();

//Report all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
</head>
<body>
  <main>

    <section class="gallery-links">
      <div class="wrapper">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
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
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                <span><strong style="margin-left: -150px; margin-top:80px;">Edit</strong></span>
                </div>
                <div>
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                <span><strong style="margin-right: -150px;">Delete</strong></span>
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

  <div class="gallery-upload">
    <form method="POST" action="" enctype="multipart/form-data">
    	<input type="hidden" name="size" value="1000000">
    	<div>
        <input type="file" id="file" name="file">
        <button type="submit" name="submit" id="submit" value="submit" formaction="upload.php">UPLOAD</button>
        <button type="submit" formaction="gallery.php">Gallery</button>
        <button type="submit" formaction="logout.php">Sign Out of Your Account</button>
        <button type="submit" id="startbutton" formaction="camera.php">Camera</button>

      </div>
    </form>
  </div>

</body>
<script>
  const fileuploader = document.getElementById('file'),
        submit = document.getElementById('submit');

  submit.setAttribute('disabled', 'true');
  fileuploader.addEventListener('change', function() {
    if (fileuploader.files.length > 0) {
      submit.removeAttribute('disabled');
    } else {
      submit.setAttribute('disabled', 'true');

    }

  });
</script>

</html>
