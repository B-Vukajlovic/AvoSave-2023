<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve entered values
    $entered_current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $repeat_password = $_POST["repeat_password"];
    // Hash entered password for comparison
    $entered_hashed = password_hash($entered_current_password, PASSWORD_DEFAULT);

    // Retrieve current password
    // TO DO: Get id with cookie
    $user_id = 1;
    $sql = "SELECT HashedPassword FROM User WHERE UserID=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute($user_id);

    // Check validation
    if (empty($entered_current_password) || empty($new_password) || empty($repeat_password)) {
        echo "All fields are required.";
    } elseif ($new_password != $repeat_password) {
        echo "New password and repeat password do not match.";
    } elseif ($entered_hashed != $current_password) {
        echo "The entered password is not correct";
    }

    else {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE User SET HashedPassword=? WHERE UserID=?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$hashed_password, $user_id]);
        echo "Password changed successfully!";
    }
} else {
    exit();
}
?>
