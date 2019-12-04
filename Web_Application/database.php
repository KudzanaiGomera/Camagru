<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
try{
    $pdo = new PDO("mysql:host=localhost;", "root", "123456");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Attempt create database query execution
try{
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

try{
    $pdo = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*user table*/
try{
    $sql = "CREATE TABLE  IF NOT EXISTS users(
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(300) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE,
        vkey VARCHAR(250) NOT NULL,
        user_email_status enum('not verified','verified') NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

/*uploads table */

try{
    $sql = "CREATE TABLE  IF NOT EXISTS uploads(
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id INT(11),
        imageFullName VARCHAR(500) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

/*Comments table*/

try{
    $sql = "CREATE TABLE  IF NOT EXISTS comments(
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id VARCHAR(50),
        comment TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(username)
    )";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

/*likes table*/

try{
    $sql = "CREATE TABLE  IF NOT EXISTS likes(
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id INT(11),
        post_id INT(11) UNIQUE,
        action TINYINT(1) NOT NULL DEFAULT '0',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (post_id) REFERENCES uploads(id)
    )";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

/*notification*/

try{
    $sql = "CREATE TABLE  IF NOT EXISTS notification(
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id INT(11),
        action TINYINT(1) NOT NULL DEFAULT '0',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

// Close connection
unset($pdo);
?>
