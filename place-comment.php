<!DOCTYPE html>
<html lang="en">

<?php

$dbname = "AvoSave";
$dbuser = "jonav";
$dbpass = "FvgrJqjhdwhBusEPsbZNkhhGszQpZezL";
$dbhost = "localhost";

try{
    $pdo = new PDO("mysql:host =" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
} catch (PDOException $e){
    echo "Database error occured: " . $e->getMessage();
    exit();
}

$recipeid;
$userid;
$time = time();

$commentinput = htmlspecialchars(stripslashes(trim($_POST["commentinput"])));

$pdo -> query("INSERT INTO Comment (CommentText, CreatedAt, RecipeID, UserID) VALUES ($commentinput, $time, $recipeid, $userid");

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'recipe-page.php';
header("Location: http://$host$uri/$extra");
exit;
?>

</html>
