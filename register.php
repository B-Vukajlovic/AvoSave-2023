<?php
    require_once('includes/pdo-connect.php');
    require_once('includes/config_session.php');
    require "login_include/registerMainLogic.php";

    if ($_SESSION['userid'] != null) {
        header('Location: index.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_include/registerStyle.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <title>Register</title>
</head>
<body>
    <?php include "includes/header.php";?>
    <div class="registerContainer">
        <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="tekstContainer">
                <h1>Welcome.</h1>
            </div>
            <div class="inputContainer">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter a Username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                <div class="usernameHelperText">
                    <?php
                        if(!empty($usernameError)) {
                            echo $usernameError;
                        }
                    ?>
                </div>
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Enter your Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <div class="emailHelperText">
                    <?php
                        if(!empty($emailError)) {
                            echo $emailError;
                        }
                    ?>
                </div>
                <label for="password">Password</label>
                <input type="password" placeholder="Enter a Password" name="password">
                <div class="passwordHelperTekst">
                    <?php
                        if(!empty($passwordError)) {
                            echo $passwordError;
                        }
                    ?>
                </div>
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Remember Me</label>
            </div>
            <div class="buttonContainer">
                <input type="submit" name="submit" value="Register">
            </div>
            <div class="generalHelperText">
                <?php
                    if(!empty($generalError)) {
                        echo $generalError;
                    }
                ?>
            </div>
            <div><a id="registerLink" href="login.php">Click Here To Login</div>
        </form>
    </div>
</body>
</html>
