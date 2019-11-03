<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with  password ) */
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

try{
    $sql = "CREATE TABLE  IF NOT EXISTS users(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(200) NOT NULL UNIQUE,
        email VARCHAR(200) NOT NULL UNIQUE,
        verified TINYINT,
        token VARCHAR(200),
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table created successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
// Close connection
unset($pdo);
?>
