<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
require_once('submission.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <link rel="stylesheet" href="profile_include/submit-recipe-styles.css">
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
                <a class="SavedNav" href="submit-recipe.php">Admin</a>
            </div>
        </div>
        <div class="mainpage">
            <h1>Submit a Recipe!<h1>
            <form method="POST" enctype="multipart/form-data">
                <div class="acc-info-input">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g. 'My Recipe'">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="This recipe...">
                    <label for="steps">Steps for the recipe</label>
                    <input type="text" id="steps" name="steps" placeholder="1...  2...">
                    <label for="servings">Servings</label>
                    <input type="text" id="servings" name="servings" placeholder="e.g. '3'">
                    <label for="time">Time (minutes)</label>
                    <input type="text" id="time" name="time" placeholder="e.g. '120'">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder = "e.g. 'John Doe'">

                    <div class="visuals">
                        <div class ="see">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="select-img">
                            <img src="" class="img" alt="...">
                            <input type="hidden" id="imgur-url" name="imgur-url">
                        </div>

                        <div class="pick">
                            <label for="ingredients">Ingredients</label>
                            <input type="hidden" id="selected-ingredients" name="selectedIngredients">
                            <div class="search-bar">
                                <input type="text" id="ingredient-search" placeholder="Search an ingredient..." class="input-search-bar">
                            </div>

                            <div class="ingredients-container">
                                <?php
                                    $ingredients = $pdo->query("SELECT Name, Type FROM Ingredient");
                                    while ($row = $ingredients->fetch()) {
                                        echo "<button type='button' class='ingredient-button' data-type='{$row['Type']}'>{$row['Name']}</button>";}
                                ?>
                            </div>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Submit the recipe">
                </div>
            </form>
        </div>
    </div>
    <script src="submit-recipe-script.js"></script>
</body>
</html>