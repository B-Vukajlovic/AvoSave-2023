<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
// var_dump($pdo);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION["userid"])){
    $UserID = $_SESSION["userid"];
    $query = "SELECT isAdmin FROM User WHERE UserID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$UserID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $result['isAdmin'];
} else {
    $UserID = NULL;
}

if (isset($_GET["recipeID"])){
    $RecipeID = filter_input(INPUT_GET, "recipeID", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    header("Location: index.php");
    die();
}

// var_dump($isAdmin);

// function dbQuery($query, $arg1=null, $arg2=null, $arg3=null, $arg4=null){
//     if (!$query) {
//         echo null;
//     } else {
//         $stmt = $pdo->prepare($query);
//         if ($arg1 == null) {
//             $stmt->execute();
//         } else if ($arg2 == null) {
//             $stmt->execute([$arg1]);
//         } else if ($arg3 == null) {
//             $stmt->execute([$arg1, $arg2]);
//         } else if ($arg4 == null) {
//             $stmt->execute([$arg1, $arg2, $arg3]);
//         } else {
//             $stmt->execute([$arg1, $arg2, $arg3, $arg4]);
//         }
//     }
// }

// var_dump($UserID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recipe_include/recipe-page-styles.css">
    <link rel="stylesheet" href="includes/colors.css">
    <link rel="stylesheet" href="includes/headerStyle.css">
    <title>Recipe</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var sessionUserID = <?php echo json_encode($UserID); ?>;
    </script>

</head>

<body>
    <div class="body-container">
    <!-- <header>
        <div class="logoCombo">
            <img src="includes/avosave_logo-removebg-preview.png" class="logo">
            <img src="includes/Logo-PhotoRoom(3).png" class="logo">
        </div>
        <nav class="navbar">
            <ul id="pageNav">
                <li class="pageTraversal" id="home"><a href="index.php">Home</a></li>
                <li class="pageTraversal" id="search"><a href="recipe-overview.php">Search</a></li>
            </ul>
            <ul id="accountNav">
                <li class="pageTraversal" id="login"><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header> -->
    <?php include_once 'includes/header.php'; ?>

    <div class="main-page">
        <div class="column1">
            <div class="back-title-grid">
                <a id="back-button" href="recipe-overview.php">
                    <img class="button" src="recipe_include/pictures/back-arrow.png" alt="&lt back">
                </a>
                <div class="title-bar"> <!--get title from database-->
                    <h1>
                        <?php
                        global $pdo, $RecipeID;
                        $result = $pdo -> query("SELECT Title FROM Recipe WHERE RecipeID = $RecipeID");
                        $title = $result->fetch(PDO::FETCH_ASSOC);
                        echo $title['Title'];
                        ?>
                    </h1>
                </div>
            </div>
            <div class="side-block"> <!--get description from database-->
                <h2 class='side-block-header'>Description</h2>
                <?php
                    global $pdo, $RecipeID;
                    $result = $pdo -> query("SELECT R.Description FROM Recipe R WHERE RecipeID = $RecipeID");
                    $description = $result->fetch(PDO::FETCH_ASSOC);
                    echo $description['Description'];
                    ?>
            </div>
        </div>
        <div class="column2">
            <div class='image-box'>
                <!-- get pictureURL from database, alt=title-->
                <?php
                    global $pdo, $RecipeID;
                    $query = "SELECT R.ImageURL FROM Recipe R WHERE R.RecipeID = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$RecipeID]);
                    $image = $stmt->fetch(PDO::FETCH_ASSOC);
                    $query = "SELECT R.Title FROM Recipe R WHERE R.RecipeID = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$RecipeID]);
                    $title = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<img class='title-image' src='".$image['ImageURL']."' alt='Picture of ".$title['Title']."'>";
                    ?>
                    <!-- <img class="title-image" src='/pictures/ApplePie.jpg' alt='Apple pie'> -->
            </div>
            <div class="recipe-card recipe-grid">
                <div class="recipe-column1">
                    <h2>Recipe card</h2>
                    <div class="recipe-section">
                    <!--get prep time and servings from database-->
                    <?php global $pdo, $RecipeID;
                    $query = $pdo -> query("SELECT Time, Servings, Author FROM Recipe WHERE RecipeID = $RecipeID");
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    echo "<ul><li>Preparation time: ".$result['Time']." mins</li>";
                    echo "<li>Servings: ".$result['Servings']."</li>";
                    echo "<li>Author: ".$result['Author']."</li></ul>";
                    ?>
                    </div>
                    <h3>Ingredients</h3>
                    <ul> <!--get amount ingredient, amount ingredient, etc, etc from database-->
                    <?php global $pdo, $RecipeID;

                    $ingredients = $pdo -> query("SELECT IngredientName, Amount, Unit FROM RecipeIngredient WHERE RecipeID = $RecipeID");

                    if ($ingredients -> rowCount() > 0) {
                        while($id = $ingredients -> fetch(PDO::FETCH_ASSOC)) {
                            $amount = $id["Amount"];
                            $name = $id["IngredientName"];
                            $unit = $id["Unit"];
                            if ($unit == 'none'){
                                echo "<li>".$amount." x ".$name."</li>";
                            } else {
                                echo "<li>".$amount." ".$unit." ".$name."</li>";
                            }
                        }
                    }
                    ?>
                    </ul>
                    <br>
                    <?php
                    global $pdo, $RecipeID;
                    $stmt = $pdo->prepare("SELECT R.StepsRecipe FROM Recipe R WHERE RecipeID = :recipeid");
                    $stmt->execute(['recipeid' => $RecipeID]);
                    $steps = $stmt->fetch(PDO::FETCH_ASSOC);
                    $str = $steps['StepsRecipe'];
                    $stepsArray = preg_split('/\d+\. /', $str, -1, PREG_SPLIT_NO_EMPTY);

                    echo "<div class='container'><ol>";
                    foreach ($stepsArray as $step) {
                        echo "<li>";
                        echo $step . "</li>";
                    }
                    echo "</ol></div>";
                    ?>
                </div>
                <div class="recipe-column2">
                <?php
                    global $pdo, $RecipeID, $UserID;
                    $savedStatus = 0;
                    if ($UserID !== NULL) {
                        $status = $pdo->query("SELECT SavedStatus FROM UserRecipe WHERE UserRecipe.UserID = $UserID AND UserRecipe.RecipeID = $RecipeID");
                        $stat = $status->fetch(PDO::FETCH_ASSOC);
                        if ($stat !== false && $stat["SavedStatus"] === 1) {
                            $savedStatus = 1;
                        }
                    }

                $array = array($savedStatus, $RecipeID);
                $str = json_encode($array);
                echo '<button id="favButton" class="saveButton" value='.$str.'>'; //button changes png, and saved status, check login!-->
                echo "</button>"
                ?>
                <p id="loginRequirement"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="comment-section">
        <h2 class="comment-title">Comment section</h2>
        <div class="new-comment">
        <?php
        if ($UserID !== NULL) {
            echo "
            <div class='new-comment inner'>
            <form method='post' action='recipe_include/place-comment.php/?RecipeID=$RecipeID'>
                <label>New comment:</label>
                <br>
                <textarea required maxlength='1024' id='commentinput' name='commentinput' placeholder='Write your comment...'></textarea>
                <div id='characterCount'>0 / 1024</div>

                <script>
                    $(document).ready(function () {
                        var textArea = $('#commentinput');
                        var characterCount = $('#characterCount');

                        textArea.on('input', function () {
                            var currentLength = textArea.val().length;
                            var maxLength = parseInt(textArea.attr('maxlength'));

                            characterCount.text(currentLength + ' / ' + maxLength);
                        });
                    });
                </script>
                <br>
                <input class='postComment' type='submit' value='Post'>
            </form>
        </div>";
        }
        ?>
        </div>
        <?php
        global $pdo, $RecipeID;
        $comments = $pdo -> query("SELECT CommentID, CreatedAt, CommentText, UserID FROM Comment WHERE RecipeID = $RecipeID ORDER BY CreatedAt DESC");

        if ($comments !== false && $comments->rowCount() > 0) {
            while ($id = $comments->fetch(PDO::FETCH_ASSOC)) {
                $commenterid = $id["UserID"];
                $result = $pdo -> query("SELECT Username FROM User WHERE User.UserID = $commenterid");
                $commenter = $result->fetch(PDO::FETCH_ASSOC);

                echo "<div class='comment'>";
                echo "<p><b>" . $commenter['Username']."</b></p>";
                if ($UserID !== null && ($commenterid == $UserID || $isAdmin)){
                    echo "<button class='delete' data-commentid='".$id['CommentID']."'>Delete comment</button>";
                }
                echo "<p class='comment-text'>".$id["CommentText"]."</p>";
                echo "<p class='comment-info'> commented on " . $id["CreatedAt"]."</p>";
                echo "</div>";
            }
        } else {
            echo "<div class ='comment'>";
            echo "<p class='comment-text'>No comments yet. Be the first to leave a comment on this recipe!</p>";
            echo "</div>";
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src = "recipe_include/SaveScript.js"></script>
    <script src= "recipe_include/DeleteComment.js"></script>
    </div>
</body>
</html>
