<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

$isAdmin = 0;

if ($_SESSION['userid'] == null) {
    header('Location: login.php');
    die();
}

function logOut(){
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

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    logOut();
}

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
                <div class="acc-info-input">
                    <a class="" href="change-password.php">Change Password</a>
                    <form id="formHeader" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="submit" id="logout" value="Log Out">
                    </form>
                </div>
        </div>
    <script src="change-password-script.js"></script>
</body>
</html>