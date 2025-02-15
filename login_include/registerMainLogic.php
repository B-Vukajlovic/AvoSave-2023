<?php
    require_once('includes/pdo-connect.php');
    require_once('includes/config_session.php');
    require "registerFunctionLogic.php";

    $usernameError = $passwordError = $generalError = "";
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
        elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $emailError = "Invalid email format";
                $formValid = false;  
        }

        if (empty($_POST["password"])) {
            $passwordError = "Password is required";
            $formValid = false;
        } else {
            $passwordCriteriaErrors = checkPassword($_POST["password"]);
            if (!empty($passwordCriteriaErrors)) {
                $passwordError = implode("<br>", $passwordCriteriaErrors);
                $formValid = false;
            }
        }

        if ($formValid) {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = $_POST["password"];

            $userExistsResult = userExists($pdo, $username, $email);

            switch ($userExistsResult) {
                case true:
                    $usernameError = "Username or email already exists";
                    break;
                case false:
                    $userId = userRegister($pdo, $username, $email, $password);
                    if ($userId) {
                        if (isset($_POST['remember_me'])) {
                            setcookie("username", $username, [
                                'expires' => time() + (86400 * 30),
                                'path' => '/',
                                'domain' => '',
                                'secure' => true,
                                'httponly' => true,
                                'samesite' => 'Lax'
                            ]);
                        }
                        $_SESSION['userid'] = $userId;
                        header('Location: ../index.php');
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
?>
