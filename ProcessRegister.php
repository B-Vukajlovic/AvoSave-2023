<?php
    include_once("pdo_connect.php");
    session_start();

    function userExists($pdo, $email) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE Email = :email");
            $stmt->bindvalue(':email', $email);
            $stmt->execute();
            return !!$stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    // userid? does this work? idk man, is that autocount or whatever it's called?
    function userRegister($pdo, $username, $hashPassword, $email) {
        try {
            $stmt = $pdo->prepare("INSERT INTO User (Username, hashedPassword, Email)
            VALUES (:value1, :value2, :value3)");

            $stmt->bindvalue(':value1', $username);
            $stmt->bindvalue(':value2', $hashPassword);
            $stmt->bindvalue(':value3', $email);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    if ($password != $confirmPassword) {
        echo "Passwords do not match.";
        header("Location: register.php");
        exit();
    }
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $exists = userExists($pdo, $email);

    if($exists) {
        header("Location: login.php");
        exit();
    }
    else {
        userRegister($pdo, $username, $hashPassword, $email);
        $result = $pdo->query("SELECT UserID FROM User WHERE Email = $email");
        $UserID = $result->fetch_assoc();
        $_SESSION["UserID"];
        header("Location: ProfilePage.php");
        exit();
    }
?>
