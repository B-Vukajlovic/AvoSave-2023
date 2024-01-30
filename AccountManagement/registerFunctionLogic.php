<?php
    function userExists($pdo, $username, $email) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE Username = ? OR Email = ?");
            $stmt->execute([$username, $email]);
            return !!$stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        }
    }

    function userRegister($pdo, $username, $email, $password) {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO User (Username, HashedPassword, Email, isAdmin)
                VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $hashPassword, $email, 0]);
            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
?>