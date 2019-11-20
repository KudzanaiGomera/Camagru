<?php
// Initialize the session
session_start();
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = $new_username = $new_email = "";
$new_password_err = $confirm_password_err = $new_username_err = $new_email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


  // Validate username
  if(empty(trim($_POST["new_username"]))){
      $new_username_err = "Please enter a new_username.";
  } else{
      // Prepare a select statement
      $sql = "UPDATE users SET username = :new_username WHERE id = :id";

      if($stmt = $pdo->prepare($sql)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":new_username", $param_username, PDO::PARAM_STR);

          // Set parameters
          $param_username = trim($_POST["new_username"]);

          // Attempt to execute the prepared statement
          if($stmt->execute()){
              if($stmt->rowCount() == 1){
                  $new_username_err = "This username is not updated.";
              } else{
                  $new_username = trim($_POST["new_username"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      unset($stmt);
  }

  // Validate email
  if(empty(trim($_POST["new_email"]))){
      $new_email_err = "Please enter your email.";
  } else{
      // Prepare a select statement
      $sql = "UPDATE users SET email = :new_email WHERE id = :id";

      if($stmt = $pdo->prepare($sql)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":new_email", $param_email, PDO::PARAM_STR);

          // Set parameters
          $param_email = trim($_POST["new_email"]);

          // Attempt to execute the prepared statement
          if($stmt->execute()){
              if($stmt->rowCount() == 1){
                  $new_email_err = "This email is already taken.";
              } else{
                  $new_email = trim($_POST["new_email"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      unset($stmt);
  }

  //generate Vkey
  $vkey = md5(time().$new_username);

  echo $vkey;

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = :password WHERE id = :id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
  <?php include 'header.php';?>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
              <label>New Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo $new_username; ?>">
              <span class="help-block"><?php echo $new_username_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($new_email_err)) ? 'has-error' : ''; ?>">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo $new_email; ?>">
              <span class="help-block"><?php echo $new_email_err; ?></span>
          </div>
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="user_profile.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php include 'footer.php' ;?>
</body>
</html>
