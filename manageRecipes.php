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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src = "admin_include/recipe_deletion.js"></script>

    <title>Profile</title>
</head>

<body>
    <div class="navbar1">
        <div class="logoCombo">
            <img src="includes/avosave_logo-removebg-preview.png" class="logo">
            <img src="includes/Logo-PhotoRoom(3).png" class="logo">
            <nav class="navbar">
                <ul id="pageNav">
                    <li class="pageTraversal" id="home"><a href="index.php">Home</a></li>
                    <li class="pageTraversal" id="search"><a href="recipe-overview.php">Search</a></li>
                </ul>
                <ul id="accountNav">
                    <li class="pageTraversal" id="login"><a href="ProfilePage.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="wrapper">
        <div class="navbar2">
            <div class="topnav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="SavedNav" href="SavedPage.php">Saved</a>
                <a class="ManAdminNav" href="manageAdmins.php">Manage admins</a>
                <a class="ManRecipeNav" href="manageAdmins.php">Manage recipes</a>
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "Title-page">Manage adminstrators</h1>
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