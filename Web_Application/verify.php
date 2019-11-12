<?php

require_once "config.php";
require_once "register.php";

if (isset($_POST['vkey'])){
  //process verification
  $vkey = $GET['vkey'];

      // Prepare a select statement

    $sql = "SELECT verified,vkey FROM users WHERE verified  = 0 AND vkey = :vkey LIMIT 1";

      if($stmt = $pdo->prepare($sql)){
          // Attempt to execute the prepared statement
          if($stmt->execute()){
              if($stmt->rowCount() == 1){
                $update = "UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1";
                if($stmt = $pdo->prepare($update)){
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        echo "Your acount has been verified. you may now login.";
                        header("location: login.php");
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }
              } else{
                  echo "This account is not verified or alraedy verified";
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      unset($stmt);
  }
  else{
  die("something went wrong");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>

</body>
</html>
