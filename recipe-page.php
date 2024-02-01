<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
// var_dump($pdo);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION["userID"])){
    $userID = $_SESSION["userID"];
    $query = "SELECT isAdmin FROM User WHERE UserID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $result['isAdmin'];
} else {
    $userID = NULL;
}

if (isset($_GET["recipeID"])){
    $recipeID = filter_input(INPUT_GET, "recipeID", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    header("Location: index.php");
    die();
}

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
        var sessionUserID = <?php echo json_encode($userID); ?>;
    </script>

</head>

<body>
    <div class="bodyContainer">
    <?php include_once 'includes/header.php'; ?>

    <div class="mainpage">
        <div class="column1">
            <div class="backTitleGrid">
                <a id="backButton" href="recipe-overview.php">
                    <img class="button" src="recipe_include/pictures/back-arrow.png" alt="&lt back">
                </a>
                <div class="titleBar"> <!--get title from database-->
                    <h1>
                        <?php
                        global $pdo, $recipeID;
                        $result = $pdo -> query("SELECT Title FROM Recipe WHERE RecipeID = $recipeID");
                        $title = $result->fetch(PDO::FETCH_ASSOC);
                        echo $title['Title'];
                        ?>
                    </h1>
                </div>
            </div>
            <div class="sideBlock"> <!--get description from database-->
                <h2 class='sideBlockHeader'>Description</h2>
                <?php
                    global $pdo, $recipeID;
                    $result = $pdo -> query("SELECT R.Description FROM Recipe R WHERE RecipeID = $recipeID");
                    $description = $result->fetch(PDO::FETCH_ASSOC);
                    echo $description['Description'];
                    ?>
            </div>
        </div>
        <div class="column2">
            <div class='imageBox'>
                <!-- get pictureURL from database, alt=title-->
                <?php
                    global $pdo, $recipeID;
                    $query = "SELECT R.ImageURL FROM Recipe R WHERE R.RecipeID = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$recipeID]);
                    $image = $stmt->fetch(PDO::FETCH_ASSOC);
                    $query = "SELECT R.Title FROM Recipe R WHERE R.RecipeID = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$recipeID]);
                    $title = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<img class='titleImage' src='".$image['ImageURL']."' alt='Picture of ".$title['Title']."'>";
                    ?>
                    <!-- <img class="title-image" src='/pictures/ApplePie.jpg' alt='Apple pie'> -->
            </div>
            <div class="recipeCard recipeGrid">
                <div class="recipeColumn1">
                    <h2>Recipe card</h2>
                    <div class="recipeSection">
                    <!--get prep time and servings from database-->
                    <?php global $pdo, $recipeID;
                    $query = $pdo -> query("SELECT Time, Servings, Author FROM Recipe WHERE RecipeID = $recipeID");
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    echo "<ul><li>Preparation time: ".$result['Time']." mins</li>";
                    echo "<li>Servings: ".$result['Servings']."</li>";
                    echo "<li>Author: ".$result['Author']."</li></ul>";
                    ?>
                    </div>
                    <h3>Ingredients</h3>
                    <ul> <!--get amount ingredient, amount ingredient, etc, etc from database-->
                    <?php global $pdo, $recipeID;

                    $ingredients = $pdo -> query("SELECT IngredientName, Amount, Unit FROM RecipeIngredient WHERE RecipeID = $recipeID");

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
                    global $pdo, $recipeID;
                    $stmt = $pdo->prepare("SELECT R.StepsRecipe FROM Recipe R WHERE RecipeID = :recipeID");
                    $stmt->execute(['recipeID' => $recipeID]);
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
                <div class="recipeColumn2">
                <?php
                    global $pdo, $recipeID, $userID;
                    $savedStatus = 0;
                    if ($userID !== NULL) {
                        $status = $pdo->query("SELECT SavedStatus FROM UserRecipe WHERE UserRecipe.UserID = $userID AND UserRecipe.RecipeID = $recipeID");
                        $stat = $status->fetch(PDO::FETCH_ASSOC);
                        if ($stat !== false && $stat["SavedStatus"] === 1) {
                            $savedStatus = 1;
                        }
                    }

                $array = array($savedStatus, $recipeID);
                $str = json_encode($array);
                echo '<button id="favButton" class="saveButton" value='.$str.'>'; //button changes png, and saved status, check login!-->
                echo "</button>"
                ?>
                <p id="loginRequirement"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="commentSection">
        <h2 class="commentTitle">Comment section</h2>
        <div class="newComment">
        <?php
        if ($userID !== NULL) {
            echo "
            <div class='newComment inner'>
            <form method='post' action='recipe_include/place-comment.php/?recipeID=$recipeID'>
                <label>New comment:</label>
                <br>
                <textarea required maxlength='1024' id='commentInput' name='commentInput' placeholder='Write your comment...'></textarea>
                <div id='characterCount'>0 / 1024</div>

                <script>
                    $(document).ready(function () {
                        var textArea = $('#commentInput');
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
        global $pdo, $recipeID;
        $comments = $pdo -> query("SELECT CommentID, CreatedAt, CommentText, UserID FROM Comment WHERE RecipeID = $recipeID ORDER BY CreatedAt DESC");

        if ($comments !== false && $comments->rowCount() > 0) {
            while ($id = $comments->fetch(PDO::FETCH_ASSOC)) {
                $commenterID = $id["UserID"];
                $result = $pdo -> query("SELECT Username FROM User WHERE User.UserID = $commenterID");
                $commenter = $result->fetch(PDO::FETCH_ASSOC);

                echo "<div class='comment'>";
                echo "<p><b>" . $commenter['Username']."</b></p>";
                if ($userID !== null && ($commenterID == $userID || $isAdmin)){
                    echo "<button class='delete' data-commentID='".$id['CommentID']."'>Delete comment</button>";
                }
                echo "<p class='commentText'>".$id["CommentText"]."</p>";
                echo "<p class='commentInfo'> commented on " . $id["CreatedAt"]."</p>";
                echo "</div>";
            }
        } else {
            echo "<div class ='comment'>";
            echo "<p class='commentText'>No comments yet. Be the first to leave a comment on this recipe!</p>";
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
