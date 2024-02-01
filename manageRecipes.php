<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');

if ($_SESSION['userid'] == null) {
    header('Location: login.php');
    die();
}

$userid = $_SESSION['userid'];
$stmt = $pdo->prepare("SELECT isAdmin FROM User WHERE UserID=?");
$stmt->execute([$userid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user['isAdmin']) {
    header('Location: index.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_include/manage_recipes_styles.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src = "admin_include/recipe_deletion.js"></script>

    <title>Profile</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <div class="wrapper">
        <div class="navbar2">
            <div class="topnav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="SavedNav" href="SavedPage.php">Saved</a>
                <a class="ManAdminNav" href="manageAdmins.php">Manage admins</a>
                <a class="ManRecipeNav" href="manageRecipes.php">Manage recipes</a>
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "Title-page">Manage recipes</h1>
            <table>
                <tr>
                    <th>RecipeID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Change</th>
                </tr>
                <?php
                    $query = "SELECT RecipeID, Title, Author
                              FROM Recipe
                              GROUP BY RecipeID";
                    $result = $pdo->query($query);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>
                        <td>' .$row['RecipeID'] . '</td>
                        <td>' .$row['Title'] . '</td>
                        <td>' .$row['Author'] . '</td>
                        <td>
                        <button class="buttonDelete" data-recipeid="'.$row['RecipeID'].'"> Delete </button>
                        </td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>