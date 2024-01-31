<?php
require_once('../includes/pdo-connect.php');
require_once('../includes/config_session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $pdo->beginTransaction();
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

    try {
        // Recipe insertion
        $insertRecipe = $pdo->prepare("INSERT INTO Recipe (Title, Description, StepsRecipe, Servings, Time, Author) VALUES (?, ?, ?, ?, ?, ?)");
        $insertRecipe->execute([
            $title,
            $description,
            $steps,
            $servings,
            $time,
            $author,
        ]);
        $recipeId = $pdo->lastInsertId();

        // Image insertion
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageUrl = $_POST['imgur-url'];
            $insertImage = $pdo->prepare("INSERT INTO Image (ImageURL, RecipeID) VALUES (?, ?)");
            $insertImage->execute([$imageUrl, $recipeId]);
        }

        // Insert selected ingredients
        $selectedIngredients = json_decode($_POST['selectedIngredients'], true);
        if (!empty($selectedIngredients)) {
            $insertIngredient = $pdo->prepare("INSERT INTO RecipeIngredient (RecipeID, Ingredient, Amount, Unit) VALUES (?, ?, ?, ?)");
            foreach ($selectedIngredients as $ingredient) {
                $insertIngredient->execute([$recipeId, $ingredient['name'], $ingredient['amount'], $ingredient['unit']]);
            }
        }

        // Commit the transaction
        $pdo->commit();
        echo "Recipe submitted successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error submitting recipe: " . $e->getMessage();
    }
}
?>

