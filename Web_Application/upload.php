<?php

/// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

if (isset($_POST['submit']))
{
  $newFileName = $_POST['filename'];
  if($_POST['filename']){
    $newFileName = "gallery";
  } else {
    $newFileName = strtolower(str_replace(" ", "-", $newFileName));
  }
  $imageTitle = $_POST['filetitle'];
  $imageDesc = $_POST['filedesc'];

  $file = $_FILES['file'];

  $fileName = $file['name'];
  $filetype = $file['file'];
  $fileTempName = $file['tmp_name'];
  $fileError = $file['error'];
  $fileSize = $file['size'];

  $fileExt = explode(".", $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array("jpg", "jpeg", "png");

  if (in_array($fileActualExt, $allowed))
  {
    if ($fileError == 0){
      if ($fileSize > 2000000){
        $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
        $fileDestination = "images/gallery/" . $imageFullName;

        if (empty($imageTitle) || empty($imageDesc)) {
          header("location: user_profile.php")
          exit();
        } else{
          $sql = "SELECT * FROM uploads";
          if (!mysqli_stmt_prepare($sql)) {
            echo "SQL statement failed";
          }else {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $rowCount = mysqli_num_rows($result);
            $setImageOrder = $rowCount + 1;

            $dql = "INSERT INTO uploads (titleGallery, descGallery, imageFullName, orderGallery) VALUES (?,?,?,?)";
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "SQL statement failed";
            }else {
              mysql_stmt_bind_param($stmt, "ssss",$imageTitle, $imageDesc, $fileName, $setImageOrder);
              mysqli_stmt_execute($stmt);

              move_upload_file($fileTempName, $fileDestination);
              header("location: user_profile.php");
            }

          }
        }
      }else {
        echo "file-size too big";
        exit();
      }

    } else{
      echo "you had an error";
      exit();
    }
  } else{
    echo "file type not support";
    exit();
  }

}
