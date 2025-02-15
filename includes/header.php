<?php
    require_once('includes/pdo-connect.php');
    require_once('includes/config_session.php');
?>

<header>
    <nav class="navBar">
        <ul class="navSubsection" id="leftBar">
            <img onclick="window.location.href = 'index.php';" id="logo" src="includes/avosave_logo-removebg-preview(1).png">
            <li onclick="window.location.href = 'index.php';" class="logoText">AvoSave</li>
        </ul>
        <ul class="navSubsection" id="middleBar">
            <li class="navLink" id="home"><a href="index.php">Home</a></li>
            <li class="navLink" id="Search"><a href="IngredientPage.php">Search</a></li>
            <li class="navLink" id="our_goal"><a href="index.php#aboutUs">Our goal</a></li>
        </ul>
        <ul class="navSubsection" id="rightBar">
            <?php if (isset($_SESSION["userid"])): ?>
                <li class="navLink" id="profile"><a href="ProfilePage.php">Profile</a></li>
            <?php else: ?>
                <li class="navLink" id="login"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
