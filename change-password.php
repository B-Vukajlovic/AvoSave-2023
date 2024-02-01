<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
if ($_SESSION['userID'] == null) {
    header('Location: login.php');
    die();
}

$currentVerify = '';
$newVerify = '';
$repeatVerify = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $enteredCurrentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $repeatPassword = $_POST["repeatPassword"];

    if (empty($enteredCurrentPassword) || empty($newPassword) || empty($repeatPassword)) {
        $currentVerify = "All fields are required.";
        $newVerify = "All fields are required.";
        $repeatVerify = "All fields are required.";
    } elseif ($newPassword != $repeatPassword) {
        $newVerify = "New password and repeat password do not match.";
        $repeatVerify = "New password and repeat password do not match.";
    } elseif (strlen($newPassword) < 8) {
        $newVerify = "Password must be at least 8 characters long.";
        $repeatVerify = "Password must be at least 8 characters long.";
    } elseif (!preg_match("#[0-9]+#", $newPassword)) {
        $newVerify = "Password must include at least one number.";
        $repeatVerify = "Password must include at least one number.";
    }elseif (!preg_match("#[\W]+#", $newPassword)) {
        $newVerify = "Password must include at least one special character.";
        $repeatVerify = "Password must include at least one special character.";
    } else {
        $userID = $_SESSION['userID'];
        $stmt = $pdo->prepare("SELECT HashedPassword FROM User WHERE UserID=?");
        $stmt->execute([$userID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($enteredCurrentPassword, $result['HashedPassword'])) {
            if ($result && password_verify($newPassword, $result['HashedPassword'])) {
                $newVerify = "New password cannot be the same as current";
                $repeatVerify = "New password cannot be the same as current";
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE User SET HashedPassword=? WHERE UserID=?");
                $updateStmt->execute([$hashedPassword, $userID]);
                $message = "Password changed successfully!";
            }
        } else {
            $currentVerify = "Current password is not correct.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_include/registerStyle.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <link rel="stylesheet" href="includes/colors.css">
    <title>Change Password</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <div class="registerContainer">
        <form method="post" id="form">
            <div class="textContainer">
                <h1>Change Password.</h1>
            </div>
            <div class="inputContainer">
                <label>Current Password:</label>
                <div id="currentVerify" class="generalHelperText"><?php if(!empty($currentVerify)) echo htmlspecialchars($currentVerify); ?></div>
                <input class="passInput" type="password" name="currentPassword"><br>
                <label>New Password:</label>
                <div id="newVerify" class="generalHelperText"><?php if(!empty($newVerify)) echo htmlspecialchars($newVerify); ?></div>
                <input class="passInput" type="password" name="newPassword"><br>
                <label>Repeat New Password:</label>
                <div id="repeatVerify" class="generalHelperText"><?php if(!empty($repeatVerify)) echo htmlspecialchars($repeatVerify); ?></div>
                <input class="passInput" type="password" name="repeatPassword"><br>
                <div id="message" class="successMsg"><?php if(!empty($message)) echo htmlspecialchars($message); ?></div>
            </div>
            <div class="buttonContainer">
                <input type="submit" name="submit" value="Change Password">
            </div>
        </form>
    </div>
    <script src="change-password-script.js"></script>
</body>
</html>