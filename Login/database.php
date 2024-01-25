<?php
$dbhost = "localhost";
$dbuser = "username";
$dbpass = "password";
$dbname = "AvoSave";

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>