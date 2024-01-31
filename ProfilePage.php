<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

$isAdmin = 0;
if ($_SESSION['userid'] == null) {
    header('Location: login.php');
    die();
} else {
    $query = "SELECT isAdmin FROM User WHERE UserID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['userid']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $result['isAdmin'];
}

$current_verify = '';
$new_verify = '';
$repeat_verify = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $entered_current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $repeat_password = $_POST["repeat_password"];

    if (empty($entered_current_password) || empty($new_password) || empty($repeat_password)) {
        $current_verify = "All fields are required.";
        $new_verify = "All fields are required.";
        $repeat_verify = "All fields are required.";
    } elseif ($new_password != $repeat_password) {
        $new_verify = "New password and repeat password do not match.";
        $repeat_verify = "New password and repeat password do not match.";
    } elseif (strlen($new_password) < 8) {
        $new_verify = "Password must be at least 8 characters long.";
        $repeat_verify = "Password must be at least 8 characters long.";
    } elseif (!preg_match("#[0-9]+#", $new_password)) {
        $new_verify = "Password must include at least one number.";
        $repeat_verify = "Password must include at least one number.";
    }elseif (!preg_match("#[\W]+#", $new_password)) {
        $new_verify = "Password must include at least one special character.";
        $repeat_verify = "Password must include at least one special character.";
    } else {
        $userid = $_SESSION['userid'];
        $stmt = $pdo->prepare("SELECT HashedPassword FROM User WHERE UserID=?");
        $stmt->execute([$userid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($entered_current_password, $result['HashedPassword'])) {
            if ($result && password_verify($new_password, $result['HashedPassword'])) {
                $new_verify = "New password cannot be the same as current";
                $repeat_verify = "New password cannot be the same as current";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare("UPDATE User SET HashedPassword=? WHERE UserID=?");
                $update_stmt->execute([$hashed_password, $userid]);
                $message = "Password changed successfully!";
            }
        } else {
            $current_verify = "Current password is not correct.";
        }
    }
}

/* function logOut(){
    session_unset();

     if (ini_get("session.use_cookies")) {
         $params = session_get_cookie_params();
         setcookie(session_name(), '', time() - 42000,
             $params["path"], $params["domain"],
             $params["secure"], $params["httponly"]
         );
     }
     session_destroy();
     header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    logOut();
}*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile_include/profilepage-style.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <title>Profile</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <div class="wrapper">
        <div class="navbar2">
            <div class="topnav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="SavedNav" href="SavedPage.php">Saved</a>
                <?php
                if ($isAdmin) {
                    echo '<a class="ManAdminNav" href="manageAdmins.php">Manage admins</a>';
                    echo '<a class="ManRecipeNav" href="manageRecipes.php">Manage recipes</a>';
                }
                ?>
            </div>
        </div>
        <div class="mainpage">
            <h1>My Account</h1>
            <h2 class="second-title">Account information</h2>
                <div class="acc-info-input">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" readonly="readonly" value="<?php
                    $userid = $_SESSION['userid'];
                    $stmt = $pdo->prepare("SELECT Username FROM User WHERE UserID=?");
                    $stmt->execute([$userid]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo htmlspecialchars($result['Username'] ?? 'Username not found');
                    ?>">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" readonly="readonly" value="<?php
                    $userid = $_SESSION['userid'];
                    $stmt = $pdo->prepare("SELECT Email FROM User WHERE UserID=?");
                    $stmt->execute([$userid]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo htmlspecialchars($result['Email'] ?? 'Your email');
                    ?>">
                </div>
            <h2 class="second-title">Change password</h2>
                <div class="acc-info-input">
                    <form method="post" id="passwordForm">
                        <label>Current Password:</label>
                        <div id="current_verify" class="passwordmsg"><?php if(!empty($current_verify)) echo htmlspecialchars($current_verify); ?></div>
                        <input class="passinput" type="password" name="current_password"><br>
                        <label>New Password:</label>
                        <div id="new_verify" class="passwordmsg"><?php if(!empty($new_verify)) echo htmlspecialchars($new_verify); ?></div>
                        <input class="passinput" type="password" name="new_password"><br>
                        <label>Repeat New Password:</label>
                        <div id="repeat_verify" class="passwordmsg"><?php if(!empty($repeat_verify)) echo htmlspecialchars($repeat_verify); ?></div>
                        <input class="passinput" type="password" name="repeat_password"><br>
                        <div id="message" class="succesmsg"><?php if(!empty($message)) echo htmlspecialchars($message); ?></div>
                        <input type="submit" name="submit" value="Change Password">
                    </form>
                </div>
        </div>
    <script src="change-password-script.js"></script>
</body>
</html>