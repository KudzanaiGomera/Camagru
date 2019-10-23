// creating or recreating database schema

<?php

require_once "database.php";

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' and  password '123456789') */
try{
    $pdo = new PDO("mysql:host=localhost;", "root", "123456789");
    /* Set the PDO error mode to exception*/
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

/* Attempt create database if it does not exits*/
try{
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    $pdo->exec($sql);
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

//trying to connect now to the created database
try{
    $pdo = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456789");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

//creating table to verify account
try{
    $sql = "CREATE TABLE  IF NOT EXISTS verify(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        email  text NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        code    text NOT NULL UNIQUE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";    
    $pdo->exec($sql);
    echo "Table created successfully.";
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

//creating table scheme for verified_user
try{
    $sql = "CREATE TABLE  IF NOT EXISTS verified_user(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        email  text NOT NULL UNIQUE,
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