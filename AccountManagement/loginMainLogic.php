<?php
    session_start();
    require_once "database.php";
    require "loginFunctionLogic.php";

    $usernameError = $passwordError = $generalError = "";
    $formValid = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $usernameError = "Username is required";
            $formValid = false;
        }

        if (empty($_POST["password"])) {
            $passwordError = "Password is required";
            $formValid = false;
        }

        if ($formValid) {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $_POST["password"];

            $user = userFetch($pdo, $username);
            if ($user && password_verify($password, $user['HashedPassword'])) {
                if (isset($_POST['remember_me'])) {
                    setcookie("user_id", $user["Username"], [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'domain' => '',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                }

                header("Location: index.php");
                exit();
            } else {
                $generalError = "Invalid username or password";
            }
        }
    }
?>