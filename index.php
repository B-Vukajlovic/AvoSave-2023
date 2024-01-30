<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index_styles.css">
    <title>Document</title>
</head>
<body>
    <div class="gridContainerHomepage">
        <header>
            <div class="logoBar">
                <li class="navText">AvoSave</li>
            </div>
            <nav class="navBar">
                <ul class="navSub" id="pageNav">
                    <li class="pageTraversal" id="home"><a href="index.php">Home</a></li>
                    <li class="pageTraversal" id="home"><a href="#aboutUs">Our goal</a></li>
                </ul>
                <ul class="navSub" id="accountNav">
                    <?php if (isset($_COOKIE["user_id"])): ?>
                        <li class="pageTraversal" id="profile"><a href="profile.php">Profile</a></li>
                    <?php else: ?>
                        <li class="pageTraversal" id="login"><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>
        <section class="homePageContent">
            <article id="homePageArticle">
                <h1>Give purpose To waste.</h1>
                <br>
                <p>Say goodbye to food waste and hello to delicious, home-cooked meals that make the most of what you've got.</p>
                <button onclick="window.location.href = 'IngredientPage.php';" id="button"> Get started </button>
                <br>
            </article>
        </section>
        <img src="pictures/HomeScreen.png" id="img1" class="homescreenImage">
        <img src="pictures/homescreenSubImage1(1)(1).png" id="img2" class="homescreenImage">
    </div>
    <div class="gridContainerMainSection" id="aboutUs">
        <img src="path-to-your-image.jpg">
        <div class="mainContent">
            <div class="textContent">
                <h1>Help Us Reduce Wasted Food</h1>
                <p>
                In a world brimming with culinary possibilities, AvoSave emerges as a beacon of
                sustainability and convenience with its advanced recipe search tool. Designed
                to cater to the needs of the environmentally conscious and the gastronomically adventurous,
                AvoSave's platform empowers users to input their available ingredients and discover
                a vast array of recipes tailored to their pantry. This innovative approach not only
                sparks creativity in the kitchen but also significantly diminishes food waste,
                ensuring that every herb, vegetable, and spice contributes to a delightful meal
                rather than ending up in the trash.
                </p>
                <br>
                <p>
                AvoSave takes the fight against food waste to the front lines, addressing the
                issue where it often starts—at home. By leveraging AvoSave's smart technology,
                households can effortlessly utilize their leftover ingredients to their full potential,
                thereby reducing the environmental footprint one recipe at a time. In transforming the
                way we think about and use our food, AvoSave is not just a tool for meal preparation;
                it's a step towards a more sustainable and waste-conscious society.
                </p>
            </div>
        </div>
    </div>
</body>
</html>


