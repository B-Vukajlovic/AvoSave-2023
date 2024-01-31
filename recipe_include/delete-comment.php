<?php
require_once("../includes/pdo-connect.php");
require_once("../includes/config_session.php");

$commentID = $_POST["commentID"];

if (!isset($_SESSION["userid"])) {
    header("Location: /recipe-page.php?RecipeID=$RecipeID");
}

if (!empty($commentID)) {
    $stmt = $pdo->prepare("DELETE FROM Comment WHERE CommentID = ?");

    $stmt->execute([$commentID]);
}
?>
