<?php

//connection
require_once "config.php";
//Report all errors
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

function setComment(){
  if (isset($_POST['commentSubmit'])){
      // $user_id = $POST['user_id'];
      // $imageFullname = $POST['imageFullname'];
      $comment = $POST['comment'];

      $sql = "INSERT INTO comments (comment) VALUES ($comment')";
      //create connection


    }
}
