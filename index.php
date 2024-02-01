<?php
    require_once('includes/pdo-connect.php');
    require_once('includes/config_session.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homepage_include/indexStyle.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <link rel="stylesheet" href="homepage_include/cookieStyle.css">
    <link rel="stylesheet" href="includes/colors.css">
    <title>Home</title>
</head>
<body>
    <?php include "includes/header.php";?>
    <section class="homePageContainer">
        <div class="homePageContent">
            <article class="homePageArticle" id="article1">
                <h1>Give Purpose To Waste.</h1>
                <br>
                <p>Say goodbye to food waste and hello to delicious, home-cooked meals that make the most of what you've got.</p>
                <button onclick="window.location.href = 'IngredientPage.php';" id="button"> Get started </button>
                <br>
            </article>
            <article class="homePageArticle" id="article2">
                <h1>Or,</h1>
                <p>Curious about what inspired AvoSave and our commitment to sustainability? Discover our story and vision.</p>
                <button onclick="window.location.href = '#aboutUs';" id="button">Discover</button>
                <br>
            </article>
        </div>
        <div class="imgContainer">
            <img src="homepage_include/pictures/colorfullFruit.png">
        </div>
    </section>
    <section class="tooltipContainer" id="aboutUs">
        <article class="tooltip">
            <p>Did you know that globally, <b>millions</b> of avocados are wasted every year simply because they ripen faster than they can be consumed or sold?</p>
        </article>
    </section>
    <section class="containerMainSection">
        <div class="mainContent" id="mainContent1">
            <div class="textContent" id="text1">
                <h1>In a world where so much food goes to waste,</h1>
                <br>
                <p>
                AvoSave stands as a beacon
                of change. Our journey began with a simple observation: too many good
                avocados were being thrown away because they ripened quicker than people
                could eat them. This isn't just about avocados, it's a small part of a
                bigger problem; global food waste.
                </p>
                <br>
                <p>
                Why does saving food matter? When we waste food, we also waste the water,
                energy, and effort put into growing it. And when thrown away, this food
                contributes to greenhouse gases in landfills. It's a cycle that affects
                our planet.
                </p>
                <br>
                <h1>That's where AvoSave steps in.</h1>
                <br>
                <p>
                Our software is designed to be super
                user-friendly, think of it as a helpful friend in the kitchen. You
                tell AvoSave what ingredients you have, like those ripe avocados,
                and it gives you recipe ideas. It's a fun, creative way to use what
                you already have, reducing waste and helping the environment.
                </p>
                <br>
                <p>
                But AvoSave isn't just about recipes; it's about educating and
                inspiring people to think differently about food. We're committed
                to sustainability, which means we care deeply about the environment
                and our impact on it. Our goal is to make reducing food waste easy
                and enjoyable for everyone.
                </p>
            </div>
        </div>
    </section>
    <footer class="footer">
        <p>&copy; 2024 AvoSave. All rights reserved.</p>
        <p><a href="privacyPolicy.php">Privacy Policy</a> | <a href="terms.php">Terms of Use</a></p>
    </footer>
    <div id="cookieConsentPopup" class="cookieConsentPopup">
        <p>This website uses cookies to ensure you get the best experience on our website. <a href="privacyPolicy.php">Learn more</a></p>
        <button id="acceptCookieConsent">Got it!</button>
    </div>
    <script src="homepage_include/cookieConsent.js"></script>
</body>
</html>
