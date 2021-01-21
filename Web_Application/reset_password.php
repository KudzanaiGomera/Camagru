<?php
// Include config file
require_once "connection/config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Validate password strength
$uppercase = preg_match('@[A-Z]@', empty($_POST["new_password"]) ? '' : $_POST["new_password"]);
$lowercase = preg_match('@[a-z]@', empty($_POST["new_password"]) ? '' : $_POST["new_password"]);
$number    = preg_match('@[0-9]@', empty($_POST["new_password"]) ? '' : $_POST["new_password"]);


if($_SERVER["REQUEST_METHOD"] == "POST"){


  //echo $vkey;

  // Validate password
  if(empty(trim($_POST["new_password"]))){
      $new_password_err = "Please enter the new password.";
      // Validate password strength
  } elseif(!$uppercase || !$lowercase || !$number || strlen(trim($_POST["new_password"])) < 8){
      $new_password_err = "Password must have atleast 8 characters in length and should include at least one upper case letter, one number.";
  } else{
      $new_password = trim($_POST["new_password"]);
  }

  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
      $confirm_password_err = "Please confirm password.";
  } else{
      $confirm_password = trim($_POST["confirm_password"]);
      if(empty($new_password_err) && ($new_password != $confirm_password)){
          $confirm_password_err = "Password did not match.";
      }
  }

  // Check input errors before inserting in database
  if(empty($new_password_err) && empty($confirm_password_err)){

      // Prepare an insert statement
      $sql = "UPDATE users SET password = :password WHERE email = :email";

      if($stmt = $pdo->prepare($sql)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
          $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

          // Set parameters
          $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
          $param_email = $_GET['email'];
          // not getting inside this query // Attempt to execute the prepared statement
          if($stmt->execute()){
            // Password updated successfully. Destroy the session, and redirect to login page
                            header("location: index.php");
                            exit();
          } else{
              echo "Something went wrong. Please try again later.";
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
</head>
<body>
  <?php include 'includes/header.php';?>
    <section class="gallery-links">
      <div class="wrapper">
      </div>
    <section>

<div class="container">
    <h1 class="text-center">Reset Password</h1>
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
          <label>New Password</label>
          <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
          <span class="help-block"><?php echo $new_password_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
          <span class="help-block"><?php echo $confirm_password_err; ?></span>
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
