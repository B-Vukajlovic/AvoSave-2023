<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

$isAdmin = 0;
if ($_SESSION['userID'] == null) {
    header('Location: login.php');
    die();
} else {
    $query = "SELECT isAdmin FROM User WHERE UserID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['userID']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $result['isAdmin'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile_include/savedpage-styles.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <link rel="stylesheet" href="includes/colors.css">
    <title>Profile</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <div class="wrapper">
        <div class="navbar2">
            <div class="topNav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="savedNav" href="SavedPage.php">Saved</a>
                <?php
                if ($isAdmin) {
                    echo '<a class="manAdminNav" href="manageAdmins.php">Manage admins</a>';
                    echo '<a class="manRecipeNav" href="manageRecipes.php">Manage recipes</a>';
                    echo '<a class="submitNav" href="submit-recipe.php">Submit recipes</a>';
                }
                ?>
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "titlePage">My Saved Recipes</h1>
            <?php
            function displayRecipes($rows){
                foreach ( $rows as $row ) {
                    error_log($row['ImageURL']);
                    echo '<a href="recipe-page.php?recipeID=' . $row[ 'RecipeID' ] . '" class="recipeLink">';
                    echo '<div class="cardHolder">';
                    echo '<div class="column1">';
                    echo '<img class="images" src="'.$row['ImageURL'].'" alt="Image '.$row['RecipeTitle'].'">';
                    echo '</div>';
                    echo '<div class="column2">';
                    echo '<h2 class="titleCard">' . htmlspecialchars($row['RecipeTitle']) . '</h2>';
                    echo '<div class="labels">';
                    $ingredients = explode( ',', $row[ 'Ingredients' ] );
                    foreach ($ingredients as $ingredient) {
                        echo '<span class="labelAvailable">' . htmlspecialchars($ingredient) . '</span>';
                    }
                    echo '</div>';
                    echo '<p class="info">Servings: '. htmlspecialchars($row['Servings']).'<p>';
                    echo '<p class="info">Time: '. htmlspecialchars($row['Time']).'<p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }

            $userID = $_SESSION["userID"];
            $query = "SELECT R.RecipeID, R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients, ImageURL, Servings, Time
                        FROM UserRecipe UR
                        JOIN Recipe AS R ON R.RecipeID = UR.RecipeID
                        JOIN RecipeIngredient AS RI ON RI.RecipeID = R.RecipeID
                        WHERE UR.SavedStatus = ? AND UR.UserID = ?
                     GROUP BY R.RecipeID";
            $stmt = $pdo->prepare($query);
            $stmt->execute([1, $userID]);
            $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );
            displayRecipes($rows);
            ?>
        </div>
    </div>
</body>

</html>