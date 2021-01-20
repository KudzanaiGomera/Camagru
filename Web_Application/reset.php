<?php
// Include config file
require_once "connection/config.php";

// Define variables and initialize with empty values
$email = empty(trim($_POST["email"])) ? "": trim($_POST["email"]);
$email_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validate email
  if(empty(trim($_POST["email"]))){
      $email_err = "Please enter your email.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM users WHERE email = :email";

      if($stmt = $pdo->prepare($sql)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

          // Set parameters
          $param_email = trim($_POST["email"]);

          // Attempt to execute the prepared statement
          if($stmt->execute()){
              if($stmt->rowCount() == 1){
                  // $email_err = "This email is already taken.";
                  //Send Email
                  $to = $email;
                  $subject = "Password Reset";
                  $message =  " click this link!<a href = 'http://localhost/Web_Application/reset_password.php?email=$email'>Reset Password</a>";
                  $headers = "From:noreply@localhost:8080 \r\n";
                  $headers .= "MIME-Version: 1.0" . "\r\n";
                  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


                  if (mail($to,$subject,$message,$headers))
                  {
                    echo ("success");
                  }
                  else {
                    echo("Fail");
                  }

                  // Redirect to verify page
                   header("location: check_email_reset.php");
              } else{
                  $email_err = "This email is does not exits";
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      unset($stmt);
  }
    // Close connection
    unset($pdo);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
</head>
<body>
  <?php include 'includes/header.php';?>
    <section class="gallery-links">
      <div class="container">
      </div>
    <section>

<div class="container">
    <h1 class="text-center">Reset Password</h1>
    <p> An e-mail is going to be sent to you with instruction to reset your password check you email.</p>
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
          <span class="help-block"><?php echo $email_err; ?></span>
      </div>
      <div class="form-group">
          <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
          <button type="reset" class="btn btn-default" value="Reset">Reset</button>
      </div>
    </form>
</div>
<?php include 'includes/footer.php' ;?>
</body>
</html>
