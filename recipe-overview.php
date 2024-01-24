<?php
require_once('pdo-connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="recipe-overview-styles.css">
  <title>Recipe overview</title>
</head>

<body>
  <h1 class="title-page"> Recipes</h1>
  <div class="container">
    <div class="search-bar">
      <input type="text" placeholder="Search..." class="input-search-bar">
    </div>
  </div>
  <div class="main-page">
    <div class="filters">
      <h1 class="left-page-title">Filter by</h1>

      <label for="filter1" class="title-filter"> Diet</label><br>
      <input type="checkbox" id="filter1" name="filter1" value="vegetarian">
      <label for="filter1"> Vegetarian</label><br>
      <input type="checkbox" id="filter2" name="filter2" value="vegan">
      <label for="filter2"> Vegan</label><br><br>

      <label for="filter1" class="title-filter"> Time</label><br>
      <input type="checkbox" id="filter3" name="filter3" value="less_15">
      <label for="filter3"> &lt 15 min</label><br>
      <input type="checkbox" id="filter4" name="filter4" value="15-30">
      <label for="filter4"> 15-30 min</label><br>
      <input type="checkbox" id="filter5" name="filter5" value="30-60">
      <label for="filter5"> 30-60 min</label><br>
      <input type="checkbox" id="filter6" name="filter6" value="60+">
      <label for="filter6"> 60+ min</label><br><br>

      <label for="filter1" class="title-filter"> Servings</label><br>
      <input type="checkbox" id="filter7" name="filter7" value="1_serving">
      <label for="filter7"> 1 serving</label><br>
      <input type="checkbox" id="filter8" name="filter8" value="2_servings">
      <label for="filter8"> 2 servings</label><br>
      <input type="checkbox" id="filter9" name="filter9" value="3_servings">
      <label for="filter9"> 3 servings</label><br>
      <input type="checkbox" id="filter10" name="filter10" value="4+_servings">
      <label for="filter10"> 4+ servings</label><br><br>

      <label for="filter1" class="title-filter"> Rating</label><br>
      <input type="checkbox" id="filter11" name="filter11" value="1_star">
      <label for="filter11"> 1 star</label><br>
      <input type="checkbox" id="filter12" name="filter12" value="2_stars">
      <label for="filter12"> 2 stars</label><br>
      <input type="checkbox" id="filter13" name="filter13" value="3_stars">
      <label for="filter13"> 3 stars</label><br>
      <input type="checkbox" id="filter14" name="filter14" value="4_stars">
      <label for="filter14"> 4 stars</label><br>
      <input type="checkbox" id="filter15" name="filter15" value="5_stars">
      <label for="filter15"> 5 stars</label><br>
    </div>
    <div class="recipes">
      <?php
        $query = "SELECT R.RecipeID, R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients
          FROM Recipe R
          JOIN RecipeIngredient AS RI ON R.RecipeID = RI.RecipeID
          GROUP BY R.RecipeID";
        $result = $pdo->query($query);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          echo '<a href="recipe-details.php?recipeID=' . $row['RecipeID'] . '" class="recipe-link">';
          echo '<div class="card-holder">';
          echo '<div class="column1">';
          echo '<img class="images" src="image1.jpg" alt="Recept 1">';
          echo '</div>';
          echo '<div class="column2">';
          echo '<h2 class="title-card">' . htmlspecialchars($row['RecipeTitle']) . '</h2>';
          echo '<div class="labels">';
          $ingredients = explode(',', $row['Ingredients']);
          foreach ($ingredients as $ingredient) {
            echo '<span class="label-available">' . htmlspecialchars($ingredient) . '</span>';
          }
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</a>';
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>

