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
  <?php include 'header.php';?>
    <section class="gallery-links">
      <div class="wrapper">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
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
            <div class="stickers">
              <?php
                   $files = glob("stickers/*.*");
                   for ($i=0; $i<count($files); $i++)
                    {
                      $image = $files[$i];
                      $supported_file = array(
                              'gif',
                              'jpg',
                              'jpeg',
                              'png'
                       );

                       $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                       if (in_array($ext, $supported_file)) {
                          // echo basename($image)."<br />"; // show only image name if you want to show full path then use this code // echo $image."<br />";
                           echo '<a href=""><img src="'.$image .'" alt="Random image" style="width:50px;height:60px;float:left;display:inline-bl
                           o";/></a>'."<br /><br />";
                          } else {
                              continue;
                          }
                        }
                     ?>
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
<?php include 'footer.php' ;?>
</body>
</html>
