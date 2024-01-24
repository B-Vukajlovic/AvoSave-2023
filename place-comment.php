<?php
session_start();

$dbname = "AvoSave";
$dbuser = "jdevries";
$dbpass = "password123";
$dbhost = "localhost";

try{
    $pdo = new PDO("mysql:host =" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
} catch (PDOException $e){
    echo "Database error occured: " . $e->getMessage();
    exit();
}

$recipeid = $_GET["recipe_id"];
$userid = $_SESSION["user_id"];
// YYYY-MM-DD HH:MM:SS format
$time = date("Y-m-d H:i:s", time());

$commentinput = htmlspecialchars(stripslashes(trim($_POST["commentinput"])));

$pdo -> query("INSERT INTO Comment (CommentText, CreatedAt, RecipeID, UserID) VALUES ($commentinput, $time, $recipeid, $userid");

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'recipe-page.php';
header("Location: http://$host$uri/$extra");
exit;
?>
