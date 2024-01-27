<?php
    session_start();
    require_once "database.php";

    function userExists($pdo, $username, $email) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE Username = ? OR Email = ?");
            $stmt->execute([$username, $email]);
            return !!$stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    function userRegister($pdo, $username, $email, $password) {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO User (Username, HashedPassword, Email)
                VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashPassword, $email]);
            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    $usernameError = $passwordError = $generalError = $emailError = "";
    $formValid = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $usernameError = "Username is required";
            $formValid = false;
        }

        if (empty($_POST["email"])) {
            $emailError = "Email is required";
            $formValid = false;
        }

        if (empty($_POST["password"])) {
            $passwordError = "Password is required";
            $formValid = false;
        }

        if ($formValid) {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = $_POST["password"];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailError = "Invalid email format";
            }
            else {
                $userExistsResult = userExists($pdo, $username, $email);

                switch ($userExistsResult) {
                    case true:
                        $usernameError = "User already exists";
                        break;
                    case null:
                        $generalError = "An error occurred. Please try again later.";
                        break;
                    case false:
                        $userId = userRegister($pdo, $username, $email, $password);
                        if ($userId) {
                            $_SESSION["userid"] = $userId;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;

                            header('Location: index.html');
                            exit();
                        } else {
                            $generalError = "An error occurred. Please try again later.";
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Document</title>
</head>
<body>
    <div class="gridContainer">
        <header>
            <div class="logoBar">
                <img src="" class="logo">
            </div>
            <nav class="navBar">
                <ul id="pageNav">
                    <li class="pageTraversal" id="home"><a href="index.html">Home</a></li>
                    <li class="pageTraversal" id="search"><a href="#">Search</a></li>
                </ul>
                <ul id="accountNav">
                    <li class="pageTraversal" id="login"><a href="login.html">Login</a></li>
                </ul>
            </nav>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="tekstContainer">
                <h1>Welcome.</h1>
            </div>
            <div class="inputContainer">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter a Username" name="username" required>
                <div class="usernameHelperText">
                    <?php
                        if(!empty($usernameError)) {
                            echo $usernameError;
                        }
                    ?>
                </div>
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
                <div class="emailHelperText">
                    <?php
                        if(!empty($emailError)) {
                            echo $emailError;
                        }
                    ?>
                </div>
                <label for="password">Password</label>
                <input type="password" placeholder="Enter a Password" name="password" required>
                <div class="passwordHelperTekst">
                    <?php
                        if(!empty($passwordError)) {
                            echo $passwordError;
                        }
                    ?>
                </div>
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
        </form>
    </div>
</body>
</html>
