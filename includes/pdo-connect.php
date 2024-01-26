<?php

$dbname = "AvoSave";
$dbuser = "jona";
$dbpass = "password";
$dbhost = "localhost";

try{
    $pdo = new PDO("mysql:host =" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo "Database error occured: " . $e->getMessage();
    exit();
}

?>