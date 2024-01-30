<?php
    session_start();
    require "login_include/registerMainLogic.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_include/registerStyle.css">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="tekstContainer">
            <h1>Welcome.</h1>
        </div>
        <div class="inputContainer">
            <label for="username">Username</label>
            <input type="text" placeholder="Enter a Username" name="username">
            <div class="usernameHelperText">
                <?php
                    if(!empty($usernameError)) {
                        echo $usernameError;
                    }
                ?>
            </div>
            <label for="email">Email</label>
            <input type="tekst" name="email" placeholder="Enter your Email">
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
        <div><a href="login.php">Click Here To Login</div>
    </form>
</body>
</html>
