<?php
require_once("../includes/pdo-connect.php");
require_once("../includes/config_session.php");

$RecipeID = filter_input(INPUT_GET, "RecipeID", FILTER_SANITIZE_SPECIAL_CHARS);
if (!isset($_SESSION["userid"])) {
    header("Location: https://in5.webtech-uva.nl/recipe-page.php?RecipeID=$RecipeID");
}
$UserID = $_SESSION["userid"];
$time = date("Y-m-d H:i:s", time());

$commentinput = filter_input(INPUT_POST, "commentinput", FILTER_SANITIZE_SPECIAL_CHARS);

if (!empty($commentinput)) {
    $stmt = $pdo->prepare("INSERT INTO Comment (CommentText, CreatedAt, RecipeID, UserID) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Error in preparing statement.');
    }

    $stmt->execute([$commentinput, $time, $RecipeID, $UserID]);
    if ($result === false) {
        die('Error in executing statement.');
    }
}

header("Location: https://in5.webtech-uva.nl/recipe-page.php?RecipeID=$RecipeID");
?>
