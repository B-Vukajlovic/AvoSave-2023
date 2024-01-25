<?php

$dbname = "AvoSave";
$dbuser = "diederickg";
$dbpass = "sfbWvcwbmaWfZoymJMTWQGUsPgFkVPAX";
$dbhost = "localhost";

try{
    $pdo = new PDO("mysql:host =" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
} catch (PDOException $e){
    echo "Database error occured: " . $e->getMessage();
    exit();
}

?>