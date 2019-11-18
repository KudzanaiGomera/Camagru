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
<html>
<head>
    <title>Camera</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="gallery-links">
      <div class="wrapper">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
        <div class="gallery-container">
          <?php
          require_once "storeImage.php";
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

<div class="container">
    <h1 class="text-center">Camera</h1>

    <form method="POST" action="" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000">
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
            </div>
            <div class="col-md-12 text-center">
                <br/>
                <button type="submit" name="submit" id="submit" value="submit" formaction="storeImage.php">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }

</script>

</body>
</html>