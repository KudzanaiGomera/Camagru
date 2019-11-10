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
    echo "Database created successfully";
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
        vkey VARCHAR(50) NOT NULL,
        verified TINYINT(1) NOT NULL DEFAULT '0',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table created successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

/*uploads table */

try{
    $sql = "CREATE TABLE  IF NOT EXISTS uploads(
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        imageFullName VARCHAR(500) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table created successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}


/*try{
    $sql = "INSERT INTO  users (username, password) VALUES ('kudzi', 'kudzanai')";
    $pdo->exec($sql);
    //echo "Records inserted successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}*/

// Close connection
unset($pdo);
?>
