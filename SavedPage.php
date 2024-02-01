<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

if ($_SESSION['userid'] == null) {
    header('Location: login.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile_include/savedpage-styles.css">
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
                <a class="ManAdminNav" href="manageAdmins.php">Manage admins</a>
                <a class="ManRecipeNav" href="manageRecipes.php">Manage recipes</a>
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "title-page">My Saved Recipes</h1>
            <?php
            $UserID = $_SESSION["userid"];
            $query = "SELECT R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients, ImageURL
                     FROM Recipe R, UserRecipe UR, Image as IG
                     JOIN RecipeIngredient AS RI ON R.RecipeID = RI.RecipeID
                     WHERE R.RecipeID = UR.RecipeID AND UR.SavedStatus = 1 AND UserID = ?
                     GROUP BY R.RecipeID";
            $stmt = $pdo->prepare($query);
            $stmt = execute([$UserID]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="column1">
                <img class="images" src="'.htmlspecialchars($row['ImageURL']).'" alt="Image '.htmlspecialchars($row['RecipeTitle']) .'">
                </div>';
                echo '<div class="column2">';
                echo '<h2 class="title-card">' . htmlspecialchars($row['RecipeTitle']) . '</h2>';
                echo '<div class="labels">';
                $ingredients = explode(',', $row['Ingredients']);
                foreach ($ingredients as $ingredient) {
                    echo '<span class="label-available">' . htmlspecialchars($ingredient) . '</span>';
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>

</html>