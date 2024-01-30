<?php
    $dbhost = "localhost";
    $dbuser = "boris";
    $dbpass = "Test1234!";
    $dbname = "AvoSave";

    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>