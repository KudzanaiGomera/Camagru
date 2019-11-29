<?php
// Initialize the session

// $_SESSION["username"] = NULL;
session_start();

require_once('config.php');
//Report all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
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
  <?php include 'header.php';?>
  <main>

    <section class="gallery-links">
      <div class="wrapper">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
        <div class="gallery-container">
          <?php
          $user_id = empty($_SESSION['id']) ? '' : $_SESSION['id'];
          //retrieve posts from the database
          $page_num = empty($_GET['pagenum']) ? '' : $_GET['pagenum'];
          if (!$page_num){
            $page_num = 1;
          }
          $i = 0;
          $nextpage = $page_num+1;
          $prevpage = $page_num-1;

          try {
            $amount = 100;
            $start = ($page_num - 1) * $amount;
            $sql = "SELECT * FROM uploads WHERE user_id = $user_id ORDER BY created_at DESC LIMIT $start, $amount";
            if (!$stmt = $pdo->prepare($sql)){
              echo "SQL statement failed";
            }else {
              $stmt->execute();
              $count = $stmt->rowCount();
              $likes = 0;

              if($page_num >= 2)
                echo "<a href='gallery.php?pagenum=$prevpage'><button type='button' class='btn btn-default btn-sm' ><span class='glyphicon glyphicon'></span>PREV</button><a/><br/>";

                if($count >= $amount)
                  echo "<a href='gallery.php?pagenum=$nextpage'><button type='button' class='btn btn-default btn-sm' ><span class='glyphicon glyphicon'></span>NEXT</button><a/><br/>";

                $res = $stmt->fetchAll();
                $i = 0;

                foreach ($res as $image) {
                  $img = $image['imageFullName'];
                  $post_id = $image['id'];
                  $user_id = empty($_SESSION['id']) ? '' : $_SESSION['id'];

                      echo '<div class="Gallery"">
                        <a href=""><div style="background-image:url(images/gallery/'.$img.');"></div>
                        <a href="delete_picture.php?post_id='.$post_id.'"><button type="button" class="btn btn-default btn-sm"  name = "like" ><span class="glyphicon glyphicon-thumbs-up"></span>Delete</button></a>
                      </a></div>'
                      ;

                      if($i == 2){
                        echo '<br>';
                        $i = -1;
                      }
                      $i++;
                }
                $c = 0;
            }
          } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br/>";
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
        <button type="submit" formaction="delete_account.php">Touch and Perish</button>
      </div>
    </form>
  </div>
<?php include 'footer.php' ;?>
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
