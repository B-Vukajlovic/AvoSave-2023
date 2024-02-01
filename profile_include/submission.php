<?php
require_once('../includes/pdo-connect.php');
require_once('../includes/config_session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $steps = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_STRING);
    $servings = filter_input(INPUT_POST, 'servings', FILTER_SANITIZE_NUMBER_INT);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);

    if (!$title || !$description || !$steps || !$servings || !$time || !$author) {
        echo "Please fill in all required fields.";
        exit;
    }

    // Image insertion
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageUrl = filter_input(INPUT_POST, 'imgur-url', FILTER_SANITIZE_URL);
    } else {
        echo "Image error.";
        exit;
    }
    // Recipe insertion
    $insertRecipe = $pdo->prepare("INSERT INTO Recipe (Title, Description, StepsRecipe, Servings, Time, Author, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertRecipe->execute([$title, $description, $steps, $servings, $time, $author, $imageUrl]);
    $recipeId = $pdo->lastInsertId();

    // Insert selected ingredients
    $selectedIngredients = json_decode($_POST['selectedIngredients'], true);
    if (!empty($selectedIngredients)) {
        $insertIngredient = $pdo->prepare("INSERT INTO RecipeIngredient (RecipeID, IngredientName, Amount, unit) VALUES (?, ?, ?, ?)");
        foreach ($selectedIngredients as $ingredient) {
            $ingredientName = filter_var($ingredient['name'], FILTER_SANITIZE_STRING);
            $amount = filter_var($ingredient['amount'], FILTER_SANITIZE_NUMBER_INT);
            $unit = filter_var($ingredient['unit'], FILTER_SANITIZE_STRING);
            $insertIngredient->execute([$recipeId, $ingredientName, $amount, $unit]);
        }
    } else {
        echo "Ingredient error.";
        exit;
    }
    echo "Recipe submitted successfully!";
    exit;
} else {
    echo "POST error.";
    exit;
}

?>

