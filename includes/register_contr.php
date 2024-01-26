<?php

declare(strict_types=1);

function emptyInputCheck(string $username, string $pwd, string $cpwd, string $email) {
    if (empty($username) || empty($pwd) || empty($cpwd) || empty($email) ) {
        return true;
    } else {
        return false;
    }
}

function invalidEmail(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function takenUsername(string $username) {
    if (getUsername($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function differentPasswords(string $pwd, string $cpwd) {
    if ($pwd === $cpwd) {
        return true;
    } else {
        return false;
    }
}

function registeredEmail(string $email) {
    if (getEmail()) {
        return true;
    } else {
        return false;
    }
}

function createUser(string $username, string $password, string $email) {
    setUser($username, $password, $email);
}
