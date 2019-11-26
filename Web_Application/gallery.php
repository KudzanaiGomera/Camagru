
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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
          $page_num = $_POST['pagenum'];
          if (!$page_num){
            $page_num = 1;
          }
          $i = 0;
          $nextpage = $page_num+1;
          $prevpage = $page_num-1;

          try {
            $amount = 6;
            $start = ($page_num - 1) * $amount;
            $sql = "SELECT * FROM uploads LIMIT $start, $amount";
            if (!$stmt = $pdo->prepare($sql)){
              echo "SQL statement failed";
            }else {
              $stmt->execute();
              $count = $stmt->rowCount();
              $likes = 0;

              if($page_num >= 2)
                echo "<a href='gallery.php?pagenum=$prevpage'><-PREV<a/><br/>";

                if($count >= $amount)
                  echo "<a href='gallery.php?pagenum=$nextpage'>NEXT-><a/><br/>";

                $res = array_reverse($stmt->fetchAll());
                $i = 0;

                foreach ($res as $image) {
                  $img = $image['imageFullName'];

                  $sql = "SELECT * FROM uploads WHERE imageFullName ='$img'";
                  // $stmt = $->prepare($sql);
                  $stmt->execute();
                  $l = $stmt->fetchAll();

                      echo '<div class="Gallery"">
                        <a href=""><div style="background-image:url(images/gallery/'.$img.');"></div>
                        <a href="like.php"><button type="button" class="btn btn-default btn-sm"  name = "like" ><span class="glyphicon glyphicon-thumbs-up"></span>Like</button></a>
                        <a href="comment.php"><button type="button" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon"></span>Comment</button></a>
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
