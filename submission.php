<?php
/*
if (isset($_POST['submit'])) {

    // Get recipe information
    $title = $_POST['title'];
    $description = $_POST['description'];
    $steps = $_POST['steps'];
    $servings = $_POST['servings'];
    $time = $_POST['time'];
    $author = $_POST['author'];
    $selectedIngredients = json_decode($_POST['selected-ingredients'], true);
   // $amount = $_PO;
   // $unit = 0;
    $imageUrl = $_POST['imgur-url'];

    // Insert recipe
    $recipeId = 0;
    $recipeId = $pdo->query("SELECT MAX(RecipeId) FROM Recipe") + 1;
    $insertRecipe = "INSERT INTO Recipe (Title, Description, StepsRecipe, Servings, Time, AuthorURL) VALUES (?,?,?,?,?,?)";
    $stmt= $pdo->prepare($insertRecipe);
    $stmt->execute($recipeId, $title, $description, $steps, $servings, $time, $author);

    // Insert ingredient information
    $insertIngredient = "INSERT INTO RecipeIngredient VALUES (?,?,?,?)";
    if (is_array($selectedIngredients) && !empty($selectedIngredients)) {
        foreach ($selectedIngredients as $ingredient) {
            $stmt= $pdo->prepare($insertIngredient);
            $stmt->execute($recipeId, $ingredient, $amount, $unit);
        }
    }

    // Error check
    if (1) {
        echo "Recipe submitted successfully!";
    } else {
        echo "Failed to submit recipe. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
*/
?>
