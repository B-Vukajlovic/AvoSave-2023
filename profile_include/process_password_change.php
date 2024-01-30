<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve entered values
    $entered_current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $repeat_password = $_POST["repeat_password"];
    $message = '';

    // Check if any fields are empty
    if (empty($entered_current_password) || empty($new_password) || empty($repeat_password)) {
        $message = "All fields are required.";
    } elseif ($new_password != $repeat_password) {
        $message = "New password and repeat password do not match.";
    } else {
        // Retrieve current hashed password from the database
        $userid = $_SESSION['userid'];
        $sql = "SELECT HashedPassword FROM User WHERE UserID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($entered_current_password, $result['HashedPassword'])) {
            // Hash new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE User SET HashedPassword=? WHERE UserID=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$hashed_password, $userid]);
            $message =  "Password changed successfully!";
        } else {
            $message =  "The entered current password is not correct.";
        }
    }
} else {
    exit();
}

?>
