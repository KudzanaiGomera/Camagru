<?php

require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: user_profile.php");
    exit;
}

if (isset($_POST['delete'])) {
       if ($_POST['delete'] == "Delete Account") {

           $login = $_POST['login'];
           $passwd = hash("whirlpool", $_POST['old_passwd']);

           $sql = "SELECT * FROM users WHERE id = '$login'";
           //preparing the statement
           if(!$stmt = $pdo->prepare($sql)){
               echo "SQL statement failed";
           }else{
             $stmt->execute();
             while($row = $stmt->fetch()){
               if ($row) {
                   if ($row['password'] === $passwd) {
                       $sql = "DELETE FROM users WHERE id = '$login'";
                       //preparing the statement
                       if(!$stmt = $pdo->prepare($sql)){
                           echo "SQL statement failed";
                       }else{
                         $stmt->execute();
                         while($row = $stmt->fetch()){
                           $_SESSION['loggued_on_user'] = "";
                           header("location: register.php");
                         };
                       }
                   } else {
                       echo "<h3 style='color: red'>Wrong password</h3>";
                   }
               } else {
                   echo "<h3 style='color: red'>Wrong login</h3>";
               }
             };
           }
       }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
</head>
<body>
  <?php include 'header.php';?>
<div class="form">
   <form method="POST" action="">
       <fieldset>
           <legend>Delete account</legend>
           <input type="text" name="login" placeholder="Login" />
           <input type="password" name="old_passwd" placeholder="Old Password" />
           <input type="password" name="new_passwd" placeholder="New Password" />
       </fieldset>
       <input type="submit" name="submit" formaction=modify.php" value="Modify" />
       <input type="submit" name="delete" value="Delete Account" />
   </form>
</div>
</body>
</html>
