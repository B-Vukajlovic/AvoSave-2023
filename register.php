<?php
    include("database.php");

    function userExists($pdo, $username) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE user = ?");
            $stmt->execute([$username]);
            return !!$stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    function userRegister($pdo, $username, $password) {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO User (Username, hashedPassword)
            VALUES (?, ?)");

            $stmt->execute([$username, $hashPassword]);
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usernameMessage = "";
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST["password"];

        $exists = userExists($pdo, $username);

        if($exists) {
            $message = "User already exists, please log in";
        }
        else {
            userRegister($pdo, $username, $password);
            echo "Registered succesfully";
            header('Location: index.html');
            exit();
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
            <!--<div class="logoBar">
                <img src="/pictures/avosave_logo-removebg-preview.png" class="logo">
            </div>-->
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
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="loginContainer">
                <div class="tekstContainer">
                    <h1>Welcome.</h1>
                </div>
                <div class="inputContainer">
                    <label for="username">Username</label>
                    <input type="text" placeholder="Enter Username" name="username" required>
                    <div class="usernameText"> <?php echo $message; ?> </div>

                    <label for="password">Password</label>
                    <input type="password" placeholder="Enter Password" name="password" required>
                </div>
                <div class="buttonContainer">
                    <input type="submit" name="sumbit" value="Register">
                </div>
            </div>
        </form>
        <img src="/pictures/colorfullFruit.png" class="image" id="img1">
        <img src="/pictures/blackFruit.png" class="image" id="img3">
        <img src="/pictures/redFruit.png" class="image" id="img5">
        <img src="/pictures/orangeFruit.png" class="image" id="img6">
        <img src="/pictures/colorFullFruit4.png" class="image" id="img7">
        <img src="/pictures/purpleFruit.png" class="image" id="img8">
    </div>
</body>
</html>
