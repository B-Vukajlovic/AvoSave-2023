<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    die();
}  else {
    $query = "SELECT isAdmin FROM User WHERE UserID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['userID']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $result['isAdmin'];
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
            <div class="topNav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="savedNav" href="SavedPage.php">Saved</a>
                <?php
                if ($isAdmin) {
                    echo '<a class="manAdminNav" href="manageAdmins.php">Manage admins</a>';
                    echo '<a class="manRecipeNav" href="manageRecipes.php">Manage recipes</a>';
                    echo '<a class="submitNav" href="submit-recipe.php">Submit recipes</a>';
                }
                ?>
            </div>
        </div>
        <div class="mainpage">
            <h1>My Account</h1>
            <h2 class="secondTitle">Account information</h2>
                <div class="accInfoInput">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" readonly="readonly" value="<?php
                    $userID = $_SESSION['userID'];
                    $stmt = $pdo->prepare("SELECT Username FROM User WHERE UserID=?");
                    $stmt->execute([$userID]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo htmlspecialchars($result['Username'] ?? 'Username not found');
                    ?>">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" readonly="readonly" value="<?php
                    $userID = $_SESSION['userID'];
                    $stmt = $pdo->prepare("SELECT Email FROM User WHERE UserID=?");
                    $stmt->execute([$userID]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo htmlspecialchars($result['Email'] ?? 'Your email');
                    ?>">
                </div>
                <div class="accInfoInput">
                    <a class="" href="change-password.php">Change Password</a>
                    <form id="formHeader" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="submit" id="logout" value="Log Out">
                    </form>
                </div>
        </div>
    <script src="change-password-script.js"></script>
</body>
</html>