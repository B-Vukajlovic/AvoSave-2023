<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homepage_include/indexStyle.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <link rel="stylesheet" href="homepage_include/cookieStyle.css">
    <title>Home</title>
</head>
<body>
    <?php include "includes/header.php";?>
    <section class="homePageContent">
        <article class="homePageArticle">
            <h1>Give Purpose To Waste.</h1>
            <br>
            <p>Say goodbye to food waste and hello to delicious, home-cooked meals that make the most of what you've got.</p>
            <button onclick="window.location.href = 'IngredientPage.php';" id="button"> Get started </button>
            <br>
        </article>
    </section>
    <section class="containerMainSection" id="aboutUs">
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
    </section>
    <div id="cookieConsentPopup" class="cookie-consent-popup">
        <p>This website uses cookies to ensure you get the best experience on our website. <a href="#">Learn more</a></p>
        <button id="acceptCookieConsent">Got it!</button>
    </div>
    <script src="homepage_include/cookieConsent.js"></script>
</body>
</html>


