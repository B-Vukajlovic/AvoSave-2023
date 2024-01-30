<?php
if (isset($_POST['submit'])) {

    // Get recipe information
    $title = $_POST['title'];
    $description = $_POST['description'];
    $steps = $_POST['steps'];
    $servings = $_POST['servings'];
    $time = $_POST['time'];
    $author = $_POST['author'];
    $selectedIngredients = json_decode($_POST['selected-ingredients'], true);
    $amount = 1;
    $unit = 'g';
    $imageUrl = $_POST['imgur-url'];

    // Insert recipe
    $recipeId = 0;
    $recipeId = $pdo->query("SELECT MAX(RecipeID) FROM Recipe") + 1;
    $insertRecipe = "INSERT INTO Recipe (Title, Description, StepsRecipe, Servings, Time, AuthorURL) VALUES (?,?,?,?,?,?)";
    $stmt= $pdo->prepare($insertRecipe);
    $stmt->execute($recipeId, $title, $description, $steps, $servings, $time, $author);

    // Insert image
    $imageId = 0;
    $imageId = $pdo->query("SELECT MAX(ImageID) FROM Image") + 1;
    $insertImage = "INSERT INTO Image (ImageID, ImageURL, RecipeID) VALUES (?,?,?)";
    $stmt= $pdo->prepare($insertImage);
    $stmt->execute($imageId, $imageUrl, $recipeId);

    // Insert ingredient information
    $insertIngredient = "INSERT INTO RecipeIngredient VALUES (?,?,?,?)";
    if (is_array($selectedIngredients) && !empty($selectedIngredients)) {
        foreach ($selectedIngredients as $ingredient) {
            $stmt= $pdo->prepare($insertIngredient);
            $stmt->execute($recipeId, $ingredient, $amount, $unit);
        }
    }
}
?>
