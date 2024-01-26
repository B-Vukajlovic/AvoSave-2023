<?php

declare(strict_types=1);
require_once 'pdo_connect.php';

function getUsername(object $pdo, string $username) {
    $query = "SELECT Username FROM User WHERE Username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getEmail(object $pdo, string $email) {
    $query = "SELECT Email FROM User WHERE Email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function setUser($username, $password, $email) {
    $query = "INSERT INTO User (Username, HashedPassword, Email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($query);

    //hash password (update?)
    $options = [
        'cost' => 12
    ];
    $password = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":email", $email);
    stmt->execute();
}
