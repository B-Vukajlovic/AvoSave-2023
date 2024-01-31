<?php
include_once("../includes/pdo-connect.php");
include_once("../includes/config_session.php");
global $pdo;

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST'){
    $savedStatus = $_POST[ 'savedStatus' ];
    $RecipeID = intval($_POST['RecipeID']);
    $UserID = intval($_SESSION["userid"]);

    try{
        if ($pdo) {
            $query = "SELECT `SavedStatus` FROM `UserRecipe` WHERE `UserID` = ? AND `RecipeID` = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$UserID, $RecipeID]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Handle the case where $pdo is null
            error_log("PDO object is null. Connection might not be established.");
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }

    if ($result !== false) {
        if ($savedStatus){
            //update database to unsaved & response = 0
            $query = "UPDATE `UserRecipe` SET `SavedStatus` = 0 WHERE `UserID` = ? AND `RecipeID` = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$UserID, $RecipeID]);
            $array = array(0, $RecipeID);
            $str = json_encode($array);
            echo $str;
        } else {
            //update database to save & response = 1
            $query = "UPDATE `UserRecipe` SET `SavedStatus` = 1 WHERE `UserID` = ? AND `RecipeID` = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$UserID, $RecipeID]);
            $array = array(1, $RecipeID);
            $str = json_encode($array);
            echo $str;
        }
    } else {
        if ($savedStatus){
            //update database to unsaved & response = 0
            $query = "INSERT INTO `UserRecipe` (`UserID`, `RecipeID`, `SavedStatus`) VALUES (?, ?, 0)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$UserID, $RecipeID]);
            $array = array(0, $RecipeID);
            $str = json_encode($array);
            echo $str;
        } else {
            //update database to save & response = 1
            $query = "INSERT INTO `UserRecipe` (`UserID`, `RecipeID`, `SavedStatus`, `Rating`) VALUES (?, ?, 1, 1)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$UserID, $RecipeID]);
            $array = array(1, $RecipeID);
            $str = json_encode($array);
            echo $str;
        }
    }
}
