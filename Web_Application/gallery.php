
<?php
// Initialize the session
session_start();

require_once "upload.php";
require_once "like.php";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
</head>
<body>
  <?php include 'header.php';?>
  <main>

    <section class="gallery-links">
      <div class="wrapper">
        <h2>Gallery</h2>
        <div class="gallery-container">
          <?php
          //retrieve posts from the database

          require_once "upload.php";
          require_once "like.php";
          $sql = "SELECT * FROM uploads ORDER BY created_at DESC";
          //preparing the statement
          if(!$stmt = $pdo->prepare($sql)){
              echo "SQL statement failed";
          }else{
            $stmt->execute();
            while($row = $stmt->fetch()){
              echo '
                <a href=""><div style="background-image:url(images/gallery/'.$row["imageFullName"].');"></div></a>
                <a href="like.php"><button type="button" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-thumbs-up"></span>Like</button></a>
                <a href="comment.php"><button type="button" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon"></span>Comment</button></a>
              ';

              $sql = "SELECT * FROM likes WHERE post_id = ".$row['id'] ."";
              if(!$stmt = $pdo->prepare($sql)){
                echo "SQL statement failed";
              }else {
                // $stmt->execute();
                while($row = $stmt->fetch()){

                }

                }

            };
          }
          $sql = "SELECT * FROM uploads ORDER BY created_at DESC";
          if(!$stmt = $pdo->prepare($sql)){
              echo "SQL statement failed";
          }else{
            $stmt->execute();
            while($stmt->{
                echo $stmt->$row_count;
            }
          ?>
        </div>
      </div>
    <section>

  </main>
  <!-- Add Jquery to page -->
  <script src="jquery.min.js"></script>
  <script>

  	$(document).ready(function(){
  		// when the user clicks on like
  		$('.like').on('click', function(){
  			var postid = $(this).data('id');
  			    $post = $(this);

  			$.ajax({
  				url: 'index.php',
  				type: 'post',
  				data: {
  					'liked': 1,
  					'postid': postid
  				},
  				success: function(response){
  					$post.parent().find('span.likes_count').text(response + " likes");
  					$post.addClass('hide');
  					$post.siblings().removeClass('hide');
  				}
  			});
  		});

  		// when the user clicks on unlike
  		$('.unlike').on('click', function(){
  			var postid = $(this).data('id');
  		    $post = $(this);

  			$.ajax({
  				url: 'index.php',
  				type: 'post',
  				data: {
  					'unliked': 1,
  					'postid': postid
  				},
  				success: function(response){
  					$post.parent().find('span.likes_count').text(response + " likes");
  					$post.addClass('hide');
  					$post.siblings().removeClass('hide');
          }
      });
    });
  });
</script>
<?php include 'footer.php' ;?>
</body>
</html>
