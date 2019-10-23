// database configuration;
<?php

//data base configs eg user, server and password
define('DB_DSN', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '123456789');
define('DB_NAME', 'camagru');
 
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . DB_DSN . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect to server " . $e->getMessage());
}
?>