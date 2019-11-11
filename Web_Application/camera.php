<?php
// Initialize the session
session_start();

//Report all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit();
}
?>

<!doctype html>
<html>
<head>
	<title>Camera Upload</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="style.css" type="text/css" media="all">
	<script src="capture.js">
	</script>
</head>
<body>
<div class="contentarea">
	<h1>
		Camera Upload
	</h1>
  <div class="camera">
    <video id="video">Video stream not available.</video>
    <button id="startbutton">Take photo</button>
  </div>
  <canvas id="canvas">
  </canvas>
  <div class="output">
    <img id="photo" alt="The screen capture will appear in this box.">
  </div>
</div>
</body>
</html>
