<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');


if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    die();
}

$userID = $_SESSION['userID'];
$stmt = $pdo->prepare("SELECT isAdmin FROM User WHERE UserID=?");
$stmt->execute([$userID]);
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
    <link rel="stylesheet" href="admin_include/manage_admins_styles.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <link rel="stylesheet" href="includes/colors.css">
    <script>
        var sessionUserID = <?php echo json_encode($userID); ?>;
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src = "admin_include/permissions_change.js"></script>

    <title>Profile</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <div class="wrapper">
        <div class="navbar2">
            <div class="topNav">
                <a class="myAccountNav" href="ProfilePage.php">My Account</a>
                <a class="savedNav" href="SavedPage.php">Saved</a>
                <a class="manAdminNav" href="manageAdmins.php">Manage admins</a>
                <a class="manRecipeNav" href="manageRecipes.php">Manage recipes</a>
                <a class="submitNav" href="submit-recipe.php">Submit recipes</a>
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "titlePage">Manage adminstrators</h1>
            <table>
                <tr>
                    <th>UserID</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>User type</th>
                    <th>Permissions</th>
                </tr>
                <?php
                    $query = "SELECT UserID, Username, Email, isAdmin
                              FROM User
                              GROUP BY UserID";
                    $result = $pdo->query($query);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $adminStatus;
                        if ($row['isAdmin'] == 0) {
                            $adminStatus = "User";
                        } else{
                            $adminStatus = "Adminstrator";
                        }
                        echo '<tr>
                        <td>' .$row['UserID'] . '</td>
                        <td>' .$row['Username'] . '</td>
                        <td>' .$row['Email'] . '</td>
                        <td id ="user'.$row['UserID'] .'">' .$adminStatus . '</td>
                        <td>
                        <button class="buttonPromote" data-userid="'.$row['UserID'].'" data-adminStatus="'.$row['isAdmin'].'"> Promote </button>
                        <button class="buttonDemote" data-userid="'.$row['UserID'].'" data-adminStatus="'.$row['isAdmin'].'"> Demote </button>

                        </tr>';
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>