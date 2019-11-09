<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "upload.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>

    <section class="gallery-links">
      <div class="wrapper">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
        <div class="gallery-container">
          <?php
          $sql = "SELECT * FROM uploads ORDER BY orderGallery DESC";
          if (mysqli_stmt_prepare($sql)){
            echo "SQL statement failed";
          }
          echo '<a href="#">
            <div></div>
            <h3>Title</h3>
            <p>Paragraph</P>
          </a>';
          ?>
        </div>
      </div>
    <section>

  </main>

  <div class="gallery-upload">
    <form method="POST" action="upload.php" method="post" enctype="multipart/form-data">
    	<input type="hidden" name="size" value="1000000">
    	<div>
    	  <input type="file" name="image">
    	</div>
    	<div>
    		<button type="submit" formaction="upload.php">Upload</button>
        <button type="submit" formaction="camera.php">Camera</button>
        <button type="submit" formaction="gallery.php">Gallery</button>
        <button type="submit" formaction="logout.php">Sign Out of Your Account</button>
    	</div>
    </form>
  </div>

</body>
</html>
