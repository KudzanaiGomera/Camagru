<?php
session_start();

// Include config file
require_once "config.php";

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$message = '';

if(isset($_GET['vkey']))
{
 $query = "SELECT * FROM users WHERE vkey = :vkey";
 $statement = $pdo->prepare($query);
 $statement->execute(
  array(
   ':vkey'   => $_GET['vkey']
  )
 );
 $no_of_row = $statement->rowCount();

 if($no_of_row > 0)
 {
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
			$_SESSION["username"] = $row['username'];
	   	if($row['user_email_status'] == 'not verified')
	   {
	    $update_query = "UPDATE users SET user_email_status = 'verified' WHERE id = '".$row['id']."'";
	    $statement = $pdo->prepare($update_query);
	    $statement->execute();
	    $sub_result = $statement->rowCount();
	    if(isset($sub_result))
	    {
	     $message = '<label class="text-success">Your email address was successfully verified <br />You can login here - <a href="index.php">login</a></label>';
			}
	   }
	   else
	   {
	    header('location: index.php');
		 }
  }
 }
 else
 {
  $message = '<label class="text-danger">Invalid Link</label>';
 }
}

?>

<!DOCTYPE html>
<html>
 <head>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
 <body>
<?php include 'header.php';?>
  <div class="container">
   <h1 align="center">Email Verification</h1>

   <h3><?php echo $message; ?></h3>

  </div>
<?php include 'footer.php' ;?>
 </body>

</html>
