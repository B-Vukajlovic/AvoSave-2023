<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

if ($_SESSION['userID'] == null) {
    header('Location: login.php');
    die();
}

$userID = $_SESSION['userID'];
$stmt = $pdo->prepare("SELECT isAdmin FROM User WHERE UserID=?");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user['isAdmin']) {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <link rel="stylesheet" href="profile_include/submit-recipe-styles.css">
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
                <a class="manAdminNav" href="manageAdmins.php">Manage admins</a>
                <a class="manRecipeNav" href="manageRecipes.php">Manage recipes</a>
                <a class="submitNav" href="submit-recipe.php">Submit recipes</a>
            </div>
        </div>
        <div class="mainpage">
            <h1>Submit a Recipe!<h1>
            <form method="POST" enctype="multipart/form-data">
                <div class="accInfoInput">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g. 'My Recipe'">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="This recipe...">
                    <label for="steps">Steps for the recipe</label>
                    <input type="text" id="steps" name="steps" placeholder="1...  2...">
                    <label for="servings">Servings</label>
                    <input type="number" id="servings" name="servings" placeholder="e.g. '3'">
                    <label for="time">Time (minutes)</label>
                    <input type="number" id="time" name="time" placeholder="e.g. '120'">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder = "e.g. 'John Doe'">

                    <div class="visuals">
                        <div class ="see">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="selectImg">
                            <img src="" class="img" alt="...">
                            <input type="hidden" id="imgurURL" name="imgurURL">
                        </div>

                        <div class="pick">
                            <label for="ingredients">Ingredients</label>
                            <input type="hidden" id="selectedIngredients" name="selectedIngredients">
                            <div class="searchbar">
                                <input type="text" id="ingredientSearch" placeholder="Search an ingredient..." class="inputSearchbar">
                            </div>

                            <div class="ingredientsContainer">
                                <?php
                                    $ingredients = $pdo->query("SELECT Name, Type FROM Ingredient");
                                    while ($row = $ingredients->fetch()) {
                                        echo "<div class='ingredientItem'>
                                                <button class='ingredientButton' type='button' data-type='{$row['Type']}' data-name='{$row['Name']}'>{$row['Name']}</button>
                                                <div class='ingredient' data-name='Ingredient Name'>
                                                    <input type='number' class='amount' placeholder='Amount'>
                                                    <select class='unit'>
                                                        <option value='units'>Unit</option>
                                                        <option value='none'>x</option>
                                                        <option value='gr'>gram</option>
                                                        <option value='mL'>milliliter</option>
                                                    </select>
                                                </div>
                                              </div>";}
                                ?>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Submit the recipe">
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="profile_include/submit-recipe-script.js"></script>
</body>
</html>