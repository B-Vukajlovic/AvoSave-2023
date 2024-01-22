<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="savedpage-styles.css">
    <title>Profile</title>
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
                <a class="myAccountNav" href="ProfilePage.html">My Account</a>
                <a class="SavedNav" href="SavedPage.html">Saved</a>
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "title-page">My Saved Recipes</h1>
            <?php
                $query = "SELECT R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients
                    FROM Recipe R, UserRecipe UR
                    JOIN RecipeIngredient AS RI ON R.RecipeID = RI.RecipeID
                    WHERE R.RecipeID = $id AND UR.RecipeID AND SavedStatus
                    GROUP BY R.RecipeID";
            $result = pdo->query($query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="column1">
                <img class="images" src="image1.jpg" alt="Recept 1">
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