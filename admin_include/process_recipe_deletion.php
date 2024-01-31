<?php
require_once('../includes/pdo-connect.php');
require_once('../includes/config_session.php');

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'RecipeID' ] )) {
    $recipeID = $_POST["RecipeID"];
    $recipeID = filter_var($recipeID, FILTER_VALIDATE_INT);
    $userID = $_SESSION['userid'];
    $sql = "SELECT isAdmin
            FROM User
            Where UserID = ?";
    $stmt = $pdo->prepare( $sql );
    $stmt->execute([$userID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userID != null && $result != 0) {
        $sql = "DELETE FROM Recipe WHERE RecipeID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$recipeID]);
    }
}

