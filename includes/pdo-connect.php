<?php

$dbname = "AvoSave";
$dbuser = "diederickg";
$dbpass = "sfbWvcwbmaWfZoymJMTWQGUsPgFkVPAX";
$dbhost = "localhost";

try{
    $pdo = new PDO("mysql:host =" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    error_log("Database error occured: " . $e->getMessage());
    exit();
}

?>
