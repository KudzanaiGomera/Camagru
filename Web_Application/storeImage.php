<?php

/// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
// session_start();

// Include config file
require_once "config.php";

//Report all errors
ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  //echo "<br />We're here!<br />";
$user_id = $_SESSION['id'];

if(isset($_POST['submit'])){

    $img = $_POST['image'];
    $folderPath = "images/gallery/";

    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';

    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);

    // function get_sticker1(){
    // $d = imagecreatefromjpeg('/'.$_SESSION['image']);
    //     $s = imagecreatefrompng('/stickers/garfield.png');
    //     imagealphablending($d,false);
    //     imagesavealpha($d,true);
    //     imagecopymerge($d,$s , 10 , 9, 0,0,81,86,100);
    //     $store = uniqid().".jpg";
    //     imagepng($d,'../Camagru/images/gallery'.$store);
    //     pic_insert($store);
    //     imagedestroy($d);
    //     imagedestroy($s);
    //     $location = $_SESSION['image'];
    // }

    // if(isset($_POST['sticker1'])){
    //   get_sticker1();
    // }
    // if(isset($_POST['sticker2'])){
    //   get_sticker2();
    // }
    // if(isset($_POST['sticker3'])){
    //   get_sticker3();
    // }
    // if(isset($_POST['sticker4'])){
    //   get_sticker4();
    // }

    $sql = "SELECT * FROM uploads";
    try {
      //preparing the statement
      if(!$stmt = $pdo->prepare($sql)){
          echo "SQL statement failed";
      }else{
        if($stmt->execute()){
          //check the result if we have a number of rows
          $number_of_rows = $stmt->fetchColumn();
          $setImageOrder = $number_of_rows + 1;

          $sql = "INSERT INTO uploads (user_id,imageFullName) VALUES (?,?)";
          if(!$stmt = $pdo->prepare($sql)){
              echo "SQL statement failed";
          }else{

            $stmt->execute([$user_id, $fileName]);

             header("location: user_profile.php?upload=success");
          }
        }
      }
    } catch (PDOException $err) {
      echo "<br/><br />";
      print_r($err);
    }

  }

?>
