<?php
require_once( 'pdo-connect.php' );

function array_order_desc($a, $b) {
    return $b['Priority'] - $a['Priority'];
}

$preferedIngredientsString = $_POST[ 'selectedIngredients' ];
$preferedIngredientsArray = json_decode( $preferedIngredientsString );

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'filtersApplied' ] ) ) {
    $filters = $_POST[ 'filtersApplied' ];
    // Retrieve the recipes
    $sql = "SELECT R.RecipeID, R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients
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
                $servings[] = 'R.Servings > 4';
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
    foreach ( $rows as $row ) {
        $matches = 0;
        $ingredients = explode( ',', $row[ 'Ingredients' ] );
        foreach ( $ingredient as $ingredients ) {
            foreach ( $preferedIngredient as $preferedIngredientsArray ) {
                if ( $ingredient == $preferedIngredient ) {
                    $matches++;
                    break;
                }
            }
        }
        $row[ 'Priority' ] = $matches;
    }
    $ordered_rows = usort($rows, 'array_order_desc');

    foreach ( $ordered_rows as $row ) {
        echo '<a href="recipe-page.php?recipeID=' . $row[ 'RecipeID' ] . '" class="recipe-link">';
        echo '<div class="card-holder">';
        echo '<div class="column1">';
        echo '<img class="images" src="image1.jpg" alt="Recipe Image">';
        echo '</div>';
        echo '<div class="column2">';
        echo '<h2 class="title-card">' . htmlspecialchars( $row[ 'RecipeTitle' ] ) . '</h2>';
        echo '<div class="labels">';
        $ingredients = explode( ',', $row[ 'Ingredients' ] );
        foreach ( $ingredients as $ingredient ) {
            echo '<span class="label-available">' . htmlspecialchars( $ingredient ) . '</span>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }

    //Default display without filters
} else {
    $sql = "SELECT R.RecipeID, R.Title AS RecipeTitle, GROUP_CONCAT(RI.IngredientName) AS Ingredients
  FROM Recipe R
  JOIN RecipeIngredient AS RI ON R.RecipeID = RI.RecipeID
  JOIN Ingredient AS I ON RI.IngredientName = I.Name
  GROUP BY R.RecipeID";
    $result = $pdo->query( $sql );
    $rows = $result->fetchAll( PDO::FETCH_ASSOC );

    //Adds priority to the recipes based on preferences
    foreach ( $rows as $row ) {
        $matches = 0;
        $ingredients = explode( ',', $row[ 'Ingredients' ] );
        foreach ( $ingredient as $ingredients ) {
            foreach ( $preferedIngredient as $preferedIngredientsArray ) {
                if ( $ingredient == $preferedIngredient ) {
                    $matches++;
                    break;
                }
            }
        }
        $row[ 'Priority' ] = $matches;
    }
    $ordered_rows = usort($rows, 'array_order_desc');
    foreach ( $ordered_rows as $row ) {
        echo '<a href="recipe-page.php?recipeID=' . $row[ 'RecipeID' ] . '" class="recipe-link">';
        echo '<div class="card-holder">';
        echo '<div class="column1">';
        echo '<img class="images" src="image1.jpg" alt="Recipe Image">';
        echo '</div>';
        echo '<div class="column2">';
        echo '<h2 class="title-card">' . htmlspecialchars( $row[ 'RecipeTitle' ] ) . '</h2>';
        echo '<div class="labels">';
        $ingredients = explode( ',', $row[ 'Ingredients' ] );
        foreach ( $ingredients as $ingredient ) {
            echo '<span class="label-available">' . htmlspecialchars( $ingredient ) . '</span>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }
}
?>
