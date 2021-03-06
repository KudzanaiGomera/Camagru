
<?php
// Initialize the session
session_start();

require_once "connection/config.php";
//Report all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$notification = empty($_GET['notification'])? '':$_GET['notification'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php' ;?>
  <main>

    <section class="gallery-links">
      <div class="wrapper">
        <h2>Gallery</h2>
        <div class="gallery-container">
          <?php
          //retrieve posts from the database
          $page_num = empty($_GET['pagenum']) ? '' : $_GET['pagenum'];
          if (!$page_num){
            $page_num = 1;
          }
          $i = 0;
          $nextpage = $page_num+1;
          $prevpage = $page_num-1;

          try {
            $amount = 7;
            $start = ($page_num - 1) * $amount;
            $sql = "SELECT * FROM uploads ORDER BY created_at DESC LIMIT $start, $amount";
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
                  $user_id = empty($_SESSION['username']) ? '' : $_SESSION['username'];



                      echo '<div class="Gallery"">
                        <a href=""><div style="background-image:url(images/gallery/'.$img.');"></div>
                        <a href="like.php?post_id='.$post_id.'"><button type="button" class="btn btn-default btn-sm"  name = "like" ><span class="glyphicon glyphicon-thumbs-up"></span>Like</button></a>
                        <a href="comment.php?post_id='.$post_id.'&notification='.$notification.'"><button type="button" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon"></span>Comment</button></a>
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
<?php include 'includes/footer.php' ;?>
<script>
$("button").click(function(){
  $("button").removeClass("active");
  $(this).addClass("active");
  console.log("hello");
});
</script>
</body>
</html>
