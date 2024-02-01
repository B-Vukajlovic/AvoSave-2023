<?php
require_once('../includes/pdo-connect.php');
require_once('../includes/config_session.php');

global $preferedIngredientsString;
global $preferedIngredientsArray;

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['selectedIngredients'] ) ) {
    $preferedIngredientsString = $_POST['selectedIngredients'];
    $preferedIngredientsArray = json_decode($preferedIngredientsString);
}

function array_order_desc($a, $b) {
    return $b['Priority'] - $a['Priority'];
}

function displayRecipes($rows, $preferedIngredientsArray){
    $recipesDisplayed = 0;
    foreach ( $rows as $row ) {
        if (!empty($preferedIngredientsArray) && $row[ 'Priority' ] == 0) {
            break;
        }
        $recipesDisplayed++;
        error_log($row['ImageURL']);
        echo '<a href="recipe-page.php?recipeID=' . $row[ 'RecipeID' ] . '" class="recipe-link">';
        echo '<div class="card-holder">';
        echo '<div class="column1">';
        echo '<img class="images" src="'.$row['ImageURL'].'" alt="Image '.$row['RecipeTitle'].'">';
        echo '</div>';
        echo '<div class="column2">';
        echo '<h2 class="title-card">' . htmlspecialchars($row['RecipeTitle']) . '</h2>';
        echo '<div class="labels">';
        $ingredients = explode( ',', $row[ 'Ingredients' ] );
        $ingredientsSelected = array();
        $ingredientsNotSelected = array();
        foreach ( $ingredients as $ingredient ) {
            $flag = 0;
            foreach ( $preferedIngredientsArray as $preferedIngredient ) {
                if ( $ingredient == $preferedIngredient) {
                    $ingredientsSelected[] = $ingredient;
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 0) {
                $ingredientsNotSelected[] = $ingredient;
            }
        }
        foreach ( $ingredientsSelected as $selectedIngredient ) {
            echo '<span class="label-available">' . htmlspecialchars( $selectedIngredient ) . '</span>';
        }
        foreach ( $ingredientsNotSelected as $notSelectedIngredient ) {
            echo '<span class="label-unavailable">' . htmlspecialchars( $notSelectedIngredient ) . '</span>';
        }
        echo '</div>';
        echo '<p class="info">Servings: '. htmlspecialchars($row['Servings']).'<p>';
        echo '<p class="info">Time: '. htmlspecialchars($row['Time']).'<p>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }
    if ($recipesDisplayed == 0) {
        echo '<h2>No recipes have been found with your ingredients/filters.</h2>';
    }
}


if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'filtersApplied' ] ) ) {
    $filters = $_POST[ 'filtersApplied' ];
    // Retrieve the recipes
    $sql = "SELECT R.RecipeID, R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients, ImageURL, Servings, Time
                FROM Recipe R
                JOIN RecipeIngredient AS RI ON R.RecipeID = RI.RecipeID
                JOIN Ingredient AS I ON RI.IngredientName = I.Name
                WHERE ";
    $conditions = array();
    $timeAmount = array();
    $servings = array();
    // Add the filter to the query
    foreach ( $filters as $filter ) {
        $sanitizedFilter = htmlspecialchars( $filter );
        switch( $sanitizedFilter ) {
            case 'vegetarian':
            $conditions[] = "R.RecipeID NOT IN (
              SELECT RI.RecipeID
              FROM RecipeIngredient AS RI
              JOIN Ingredient AS I ON RI.IngredientName = I.Name
              WHERE I.Type IN ('Meat', 'Fish and Seafood'))";
                break;
            case 'vegan':
                $conditions[] = "R.RecipeID NOT IN (
                    SELECT RI.RecipeID
                    FROM RecipeIngredient AS RI
                    JOIN Ingredient AS I ON RI.IngredientName = I.Name
                    WHERE I.Type IN ('Meat', 'Fish and Seafood', 'Dairy and Eggs'))";
                break;
            case 'less15':
                $timeAmount[] = 'R.Time < 15';
                break;
            case '15to30':
                $timeAmount[] = 'R.Time >= 15 AND R.Time <= 30';
                break;
            case '30to60':
                $timeAmount[] = 'R.Time >= 30 AND R.Time <= 60';
                break;
            case '60more':
                $timeAmount[] = 'R.Time > 60';
                break;
            case '1serving':
                $servings[] = 'R.Servings = 1';
                break;
            case '2servings':
                $servings[] = 'R.Servings = 2';
                break;
            case '3servings':
                $servings[] = 'R.Servings = 3';
                break;
            case '4moreservings':
                $servings[] = 'R.Servings >= 4';
                break;
        }
    }

    $timeAmountString = '(' . implode( ' OR ', $timeAmount ) . ')';
    $servingsString = '(' . implode( ' OR ', $servings ) . ')';
    //Check if strings are not empty
    if ( $timeAmountString != '()' ) {
        $conditions[] = $timeAmountString;
    }
    if ( $servingsString != '()' ) {
        $conditions[] = $servingsString;
    }

    // Add the conditions to the query
    $sql .= implode( ' AND ', $conditions );
    $sql .= ' GROUP BY R.RecipeID';
    $result = $pdo->query( $sql );
    $rows = $result->fetchAll( PDO::FETCH_ASSOC );

    //Adds priority to the recipes based on preferences
    foreach ($rows as $key => $row) {
        $matches = 0;
        $ingredients = explode( ',', $row[ 'Ingredients' ] );
        foreach ( $ingredients as $ingredient ) {
            foreach ( $preferedIngredientsArray as $preferedIngredient ) {
                if ( $ingredient == $preferedIngredient ) {
                    $matches++;
                    break;
                }
            }
        }
        $rows[$key]['Priority'] = $matches;
    }
    usort($rows, 'array_order_desc');
    displayRecipes($rows, $preferedIngredientsArray);

//Default display without filters
} else {
    $sql = "SELECT R.RecipeID, R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients, ImageURL, Servings, Time
  FROM Recipe R
  JOIN RecipeIngredient AS RI ON R.RecipeID = RI.RecipeID
  JOIN Ingredient AS I ON RI.IngredientName = I.Name
  GROUP BY R.RecipeID";
    $result = $pdo->query( $sql );
    $rows = $result->fetchAll( PDO::FETCH_ASSOC );

    //Adds priority to the recipes based on preferences
    if ($preferedIngredientsArray != null) {
        foreach ($rows as $key => $row) {
            $matches = 0;
            $ingredients = explode( ',', $row[ 'Ingredients' ] );
            foreach ( $ingredients as $ingredient ) {
                foreach ( $preferedIngredientsArray as $preferedIngredient ) {
                    if ( $ingredient == $preferedIngredient ) {
                        $matches++;
                        break;
                    }
                }
            }
            $rows[$key]['Priority'] = $matches;
        }
        usort($rows, 'array_order_desc');
    }
    displayRecipes($rows, $preferedIngredientsArray);

}
?>
