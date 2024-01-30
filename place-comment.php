<?php
require_once('includes/pdo_connect.php');
require_once("includes/config_session.php");

$recipeid = $_GET["recipe_id"];
if (!isset($_SESSION["UserID"])) {
    header("Location: recipe-page.php/?RecipeID=".$recipeid);
}
$userid = $_SESSION["UserID"];
// YYYY-MM-DD HH:MM:SS format
$time = date("Y-m-d H:i:s", time());

$commentinput = htmlspecialchars(stripslashes(trim($_POST["commentinput"])));

$pdo -> query("INSERT INTO Comment (CommentText, CreatedAt, RecipeID, UserID) VALUES ($commentinput, $time, $recipeid, $userid");

header("Location: recipe-page.php/?RecipeID=".$recipeid);
?>
