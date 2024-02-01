<?php
require_once("../includes/pdo-connect.php");
require_once("../includes/config_session.php");

$recipeID = filter_input(INPUT_GET, "RecipeID", FILTER_SANITIZE_SPECIAL_CHARS);
if (!isset($_SESSION["userID"])) {
    header("Location: /recipe-page.php?RecipeID=$recipeID");
    exit();
}
$userID = $_SESSION["userID"];
$time = date("Y-m-d H:i:s", time());

$commentInput = filter_input(INPUT_POST, "commentinput", FILTER_SANITIZE_SPECIAL_CHARS);

if (!empty($commentInput)) {
    $stmt = $pdo->prepare("INSERT INTO Comment (CommentText, CreatedAt, RecipeID, UserID) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Error in preparing statement.');
    }

    $result = $stmt->execute([$commentinput, $time, $recipeID, $userID]);
    $result = $stmt->execute([$commentinput, $time, $recipeID, $userID]);
    if ($result === false) {
        die('Error in executing statement.');
    }
}

header("Location: /recipe-page.php?recipeID=$recipeID");
die();
?>
