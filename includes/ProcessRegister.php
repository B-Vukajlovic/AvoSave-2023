<?php
//source: https://www.youtube.com/watch?v=Ojk70Ag8Ofs
    require_once("config_session.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $email = $_POST["email"];

        try {
            require_once 'pdo_connect.php';
            require_once 'register_model.php';
            require_once 'register_contr.php';

            // error handling
            $errors = [];

            if (emptyInputCheck($username, $password, $confirmPassword, $email)) {
                $errors["emptyInput"] = "All fields must be filled out.";
            }
            if (invalidEmail($username, $password, $confirmPassword, $email)) {
                $errors["invalidEmail"] = "Invalid email.";
            }
            if (takenUsername($username)) {
                $errors["takenUsername"] = "This username is already taken.";

            }
            if (differentPasswords($password, $confirmPassword)) {
                $errors["differentPasswords"] = "Passwords don't match up.";

            }
            if (registeredEmail($email)) {
                $errors["registeredEmail"] = "This email address is already registered, please log in instead.";

            }

            if ($errors) {
                $_SESSION["errorsRegister"] = $errors;
                header("Location: ../register.php");
            }

            createUser($username, $password, $email);

            header("Location: ../index.html");
            die();

        } catch (PDOException $e){
            echo "Register query failed: " . $e->getMessage();
            die();
        }
    } else {
        header("Location: ../index.php");
    }
