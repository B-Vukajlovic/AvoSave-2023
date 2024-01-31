<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
$ingredients = $pdo->query("SELECT Name, Type FROM Ingredient");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ingredient_include/ingredientpage-style.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <title>Pick Ingredients</title>
</head>
<body>
    <?php include "includes/header.php";?>

    <div class="center">
        <h1>Choose ingredients to include</h1>
    </div>

    <section class="filter">
        <div class="search-bar">
            <input type="text" id="ingredient-search" placeholder="Search an ingredient..." class="input-search-bar">
        </div>
        <div id="dropdown">
            <select class="dropdown-menu" id="dropdown-content">
                <option value="All">All</option>
                <option value="Fruits">Fruits</option>
                <option value="Vegetables">Vegetables</option>
                <option value="Meat">Meat</option>
                <option value="Fish and Seafood">Fish and Seafood</option>
                <option value="Dairy and Eggs">Dairy and Eggs</option>
                <option value="Oils and Seasoning">Oils and Seasoning</option>
                <option value="Nuts and Seeds">Nuts and Seeds</option>
                <option value="Grains">Grains</option>
            </select>
        </div>
        <div>
             <form id="ingredient-form" action="recipe-overview.php" method="post">
                <input type="hidden" id="selected-ingredients" name="selectedIngredients">
                <button type="submit" class="next">View Recipes</button>
            </form>
        </div>
    </section>

    <section class="tools">
        <div class="ingredients-container">
            <?php while ($row = $ingredients->fetch()) {
                echo "<button class='ingredient-button' data-type='{$row['Type']}'>{$row['Name']}</button>";}
            ?>
        </div>

    </section>
    <script src="ingredient_include/ingredientpage-script.js"></script>
</body>
</html>
