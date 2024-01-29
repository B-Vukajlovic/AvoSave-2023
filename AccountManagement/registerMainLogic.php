<?php
    require_once "database.php";
    require "registerFunctionLogic.php";

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
                    case false:
                        $userId = userRegister($pdo, $username, $email, $password);
                        if ($userId) {
                            if (isset($_POST['remember_me'])) {
                                setcookie("user_id", $userId, time() + (86400 * 30));
                            } else {
                                setcookie("user_id", $userId, time() + (3600));
                            }
                            header('Location: index.php');
                            exit();
                        } else {
                            $generalError = "An error occurred. Please try again.";
                        }
                        break;
                    default:
                        $generalError = "An error occurred. Please try again.";
                        break;
                }
            }
        }
    }
?>