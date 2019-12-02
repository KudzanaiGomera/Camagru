<?php

require_once "config.php";

//session start
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Define variables and initialize with empty values
$new_username = $new_password = $confirm_password = $new_email = "";
$new_username_err = $new_password_err = $confirm_password_err = $new_email_err = "";

// Validate password strength
$uppercase = preg_match('@[A-Z]@', empty($_POST["new_password"]) ? '' : $_POST["new_password"]);
$lowercase = preg_match('@[a-z]@', empty($_POST["new_password"]) ? '' : $_POST["new_password"]);
$number    = preg_match('@[0-9]@', empty($_POST["new_password"]) ? '' : $_POST["new_password"]);

// Processing form data when form is submitted
if(isset($_POST['submit'])){

    // Validate username
    if(empty(trim($_POST["new_username"]))){
        $new_username_err = "Please enter a new username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = $user_id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["new_username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute([$user_id])){
                if($stmt->rowCount() == 1){
                    $new_username = trim($_POST["new_username"]);
                } else{
                    $new_username_err = "This username is does not exits.";
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
        $new_email_err = "Please enter your new email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = $user_id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["new_email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute([$user_id])){
                if($stmt->rowCount() == 1){
                  $new_email = trim($_POST["new_email"]);

                } else{
                    $new_email_err = "This email is does not exits.";
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


    // Validate password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter a  new password.";
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
    if(empty($new_username_err) && empty($new_password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "UPDATE users SET username = :username, password = :password, email = :email, vkey = :vkey WHERE id = $user_id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":vkey", $param_vkey, PDO::PARAM_STR);
            // Set parameters
            $param_username = $new_username;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $new_email;
            $param_vkey = $vkey;

            // not getting inside this query // Attempt to execute the prepared statement
            if($stmt->execute()){

                //Send Email
                $to = $new_email;
                $subject = "Email Verification";
                $message =  " click this link!<a href = 'http://localhost:8080/Web_Application/verify.php?vkey=$vkey'>Register Account</a>";
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
                 header("location: check_email.php");
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
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
              <label>New Username</label>
              <input type="text" name="new_username" class="form-control" value="<?php echo $new_username; ?>">
              <span class="help-block"><?php echo $new_username_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($new_email_err)) ? 'has-error' : ''; ?>">
              <label>Email</label>
              <input type="email" name="new_email" class="form-control" value="<?php echo $new_email; ?>">
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
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="user_profile.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php include 'footer.php' ;?>
</body>
</html>

<?php
if(isset($_POST['submit'])){
echo "helo";
}
 ?>
