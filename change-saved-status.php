<?php
require_once('includes/pdo-connect.php'); //locations fix
require_once('includes/config_session.php');

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST'){
    $savedStatus = $_POST[ 'savedStatus' ];
    $UserID = $_SESSION["UserID"];

    $query = "SELECT SavedStatus FROM UserRecipe WHERE UserID = :UserID AND RecipeID = :RecipeID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":UserID", $_SESSION["UserID"]);
    $stmt->bindParam(":RecipeID", $RecipeID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        if ($savedStatus){
            //update database to unsaved & response = 0
            $query = "UPDATE UserRecipe SET SavedStatus = 0 WHERE UserID = :UserID AND RecipeID = :RecipeID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":UserID", $UserID);
            $stmt->bindParam(":RecipeID", $RecipeID);
            $stmt->execute();
            $array = array(0, $RecipeID);
            $str = json_encode($array);
            echo $str;
        } else {
            //update database to save & response = 1
            $query = "UPDATE UserRecipe SET SavedStatus = 1 WHERE UserID = :UserID AND RecipeID = :RecipeID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":UserID", $UserID);
            $stmt->bindParam(":RecipeID", $RecipeID);
            $stmt->execute();
            $array = array(1, $RecipeID);
            $str = json_encode($array);
            echo $str;
        }
    } else {
        if ($savedStatus){
            //update database to unsaved & response = 0
            $query = "INSERT INTO 'UserRecipe' ('UserID', 'RecipeID', 'SavedStatus') VALUES ($UserID, $RecipeID, 0)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":UserID", $UserID);
            $stmt->bindParam(":RecipeID", $RecipeID);
            $stmt->execute();
            $array = array(0, $RecipeID);
            $str = json_encode($array);
            echo $str;
        } else {
            //update database to save & response = 1
            $query = "INSERT INTO 'UserRecipe' ('UserID', 'RecipeID', 'SavedStatus') VALUES ($UserID, $RecipeID, 1)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":UserID", $UserID);
            $stmt->bindParam(":RecipeID", $RecipeID);
            $stmt->execute();
            $array = array(1, $RecipeID);
            $str = json_encode($array);
            echo $str;
        }
    }
}
