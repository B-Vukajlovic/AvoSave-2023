<?php
    include_once("pdo_connect.php");
    session_start();

    function userExists($pdo, $username) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE user = :user");
            $stmt->bindvalue(':user', $username);
            $stmt->execute();
            return !!$stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    function userRegister($pdo, $username, $password) {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO User (Username, hashedPassword)
            VALUES (:value1, :value2)");

            $stmt->bindvalue(':value1', $username);
            $stmt->bindvalue(':value2', $hashPassword);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $_POST["password"];
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $exists = userExists($pdo, $username);

            if($exists) {
                $result = $pdo->query("SELECT UserID FROM User WHERE Username = $username");
                $UserID = $result->fetch_assoc();
                $result = $pdo->query("SELECT HashedPassword FROM User WHERE UserID = $UserID");
                $compareHash = $result->fetch_assoc();
                if ($hashPassword == $compareHash) {
                    $_SESSION["UserID"] = $UserID;
                    header("Location: index.html");
                    exit();
                } else {
                    echo "<p>Login failed.</p>";
                    header("Location: login.php");
                    exit();
                }
            }
            else {
                header("Location: register.php");
                exit();
            }
?>
