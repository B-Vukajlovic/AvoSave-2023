<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="submit-recipe-styles.css">
    <title>Document</title>
</head>

<body>
<div class="navbar1">
        <div class="logoCombo">
            <img src="/VIdeos/avosave_logo-removebg-preview.png" class="logo">
            <img src="/VIdeos/Logo-PhotoRoom(3).png" class="logo">
            <nav class="navbar">
                <ul id="pageNav">
                    <li class="pageTraversal" id="home"><a href="#">Home</a></li>
                    <li class="pageTraversal" id="search"><a href="#">Search</a></li>
                </ul>
                <ul id="accountNav">
                    <li class="pageTraversal" id="login"><a href="#">Login</a></li>
                </ul>
            </nav>
        </div>
    </div>
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
            <form action="process_password_change.php" method="post">
                <div class="acc-info-input">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Your title...">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="Your description...">
                    <label for="steps">Steps for the recipe</label>
                    <input type="text" id="steps" name="steps" placeholder="1...  2...">
                    <label for="servings">Servings</label>
                    <input type="text" id="servings" name="servings" placeholder="Amount of servings">
                    <label for="time">Time (minutes)</label>
                    <input type="text" id="time" name="time" placeholder="Amount of minutes">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder = "Your author">
                    <label for="ingredients">Ingredients</label>
                    <input type="text" id="ingredients" name="ingredients">
                    <input type="submit" value="Submit the recipe">
                </div>
            </form>
        </div>
    </div>
</body>
</html>