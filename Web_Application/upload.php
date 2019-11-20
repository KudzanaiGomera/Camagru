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

if (isset($_POST['submit']))
{

  $newFileName = $_POST['filename'];
  if(empty($newFileName)){
    $newFileName = "gallery";
  } else {
    $newFileName = strtolower(str_replace(" ", "-", $newFileName));
  }

  $file = $_FILES['file'];

  $fileName = $file['name'];
 	$filetype = $file['type'];
  $fileTempName = $file['tmp_name'];
  $fileError = $file['error'];
  $fileSize = $file['size'];

	$fileExt = explode(".", $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array("jpg", "jpeg", "png");

  if (in_array($fileActualExt, $allowed)){
		if ($fileError === 0){
      if ($fileSize < 20000000){
        $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
        $fileDestination = "images/gallery/" . $imageFullName;

        if (empty($imageFullName)){
          header("location: user_profile.php");
          // exit();
        } else{
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

                $sql = "INSERT INTO uploads (imageFullName) VALUES (?)";
                if(!$stmt = $pdo->prepare($sql)){
                    echo "SQL statement failed";
                }else{

                  $stmt->execute([$imageFullName]);

                  move_uploaded_file($fileTempName, $fileDestination);
                   header("location: user_profile.php?upload=success");
                }
              }
            }
          } catch (PDOException $err) {
            echo "<br/><br />";
            print_r($err);
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
