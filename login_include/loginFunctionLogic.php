<?php
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