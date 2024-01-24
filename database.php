<?php
$servername = "localhost";
$username = "borisv";
$password = "";
$dbname = "AvoSave";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>