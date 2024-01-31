<?php
    require_once('includes/pdo-connect.php');
    require_once('includes/config_session.php');

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
   }

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        logOut();
    }
?>

<header>
    <nav class="navBar">
        <ul class="navSubsection" id="leftBar">
            <li class="logoText">AvoSave</li>
        </ul>
        <ul class="navSubsection" id="middleBar">
            <li class="navLink" id="home"><a href="index.php">Home</a></li>
            <li class="navLink" id="our goal"><a href="#aboutUs">Our goal</a></li>
        </ul>
        <ul class="navSubsection" id="rightBar">
            <?php if (isset($_SESSION["userid"])): ?>
                <li class="logoutButton" id="logout">
                    <form id="formHeader" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="submit" id="logout" value="Log Out">
                    </form>
                </li>
                <li class="navLink" id="profile"><a href="ProfilePage.php">Profile</a></li>
            <?php else: ?>
                <li class="navLink" id="login"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
