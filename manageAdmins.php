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
    <link rel="stylesheet" href="admin_include/manage_admins_styles.css">
    <script>
        var sessionUserID = <?php echo json_encode($userid); ?>;
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src = "admin_include/permissions_change.js"></script>

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
            </div>
        </div>
        <div class="mainpage">
            <h1 class = "Title-page">Manage adminstrators</h1>
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