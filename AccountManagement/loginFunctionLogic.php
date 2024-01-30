<?php
    function checkPassword($password) {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        if (!preg_match("#[0-9]+#", $password)) {
            $errors[] = "Password must include at least one number.";
        }

        if (!preg_match("#[\W]+#", $password)) {
            $errors[] = "Password must include at least one special character.";
        }

        return $errors;
    }

    function userFetch($pdo, $username) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE Username = ?");
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        }
    }
?>