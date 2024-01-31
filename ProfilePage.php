<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile_include/profilepage-style.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <title>Profile</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <div class="wrapper">
        <div class="navbar2">
            <div class="topnav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="SavedNav" href="SavedPage.php">Saved</a>
            </div>
        </div>
        <div class="mainpage">
            <h1>My Account</h1>
            <h2 class="second-title">Account information</h2>
                <div class="acc-info-input">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" readonly="readonly" value="Your username">
                    <label for="email">E-mail</label>
                    <input type="text" id="email" name="email" readonly="readonly" value="Your username">
                </div>
            <h2 class="second-title">Change password</h2>
            <form action="process_password_change.php" method="post">
                <div class="acc-info-input">
                    <label for="username">Current Password</label>
                    <input type="password" id="username" name="username">
                    <label for="username">New Password</label>
                    <input type="password" id="username" name="username">
                    <label for="username">Repeat Password</label>
                    <input type="password" id="username" name="username">
                    <input type="submit" value="Submit your new password">
                </div>
            </form>
        </div>
    </div>
</body>

</html>