<?php
    include_once("pdo_connect.php");
    session_start();
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
                    <li class="pageTraversal" id="login"><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </header>
        <form action="ProcessRegister.php" method="post">
            <div class="loginContainer">
                <div class="tekstContainer">
                    <h1>Welcome.</h1>
                </div>
                <div class="inputContainer">
                    <label> for="email">Email</label>
                    <input type="email" placeholder="Enter your email" name="email" required>

                    <label for="username">Username</label>
                    <input type="text" placeholder="Enter Username" name="username" required>

                    <label for="password">Password</label>
                    <input type="password" placeholder="Enter password" name="password" required>
                    <input type="password" placeholder="Repeat your password" name="confirmPassword" required>
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
