<?php
require_once('includes/pdo-connect.php');
require_once('includes/config_session.php');
// var_dump($pdo);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
} else {
    $UserID = NULL;
}

if (isset($_GET["RecipeID"])){
    $RecipeID = filter_input(INPUT_GET, "RecipeID", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $RecipeID = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recipe_include/recipe-page-styles.css">
    <link rel="stylesheet" href="includes/colors.css">
    <base href="http://localhost:8080/">
    <title>Recipe</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var sessionUserID = <?php echo json_encode($UserID); ?>;
    </script>

</head>

<body>
    <header>
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
    </header>

    <div class="main-page">
        <div class="column1">
            <div class="back-title-grid">
                <a id="back-button" href="javascript:window. history. back();">
                    <img class=button src="recipe_include/pictures/back-arrow.png" alt="&lt back">
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
                <h2>Description</h2>
                <?php
                    global $pdo, $RecipeID;
                    $result = $pdo -> query("SELECT R.Description FROM Recipe R WHERE RecipeID = $RecipeID");
                    $description = $result->fetch(PDO::FETCH_ASSOC);
                    echo $description['Description'];
                    ?>
            </div>
        </div>
        <div class="column2">
            <div>
                <!-- get pictureURL from database, alt=title-->
                <?php
                    global $pdo, $RecipeID;
                    $imgResult = $pdo -> query("SELECT ImageURL FROM Image WHERE Image.RecipeID = $RecipeID");
                    $titleResult = $pdo -> query("SELECT Title FROM Recipe WHERE RecipeID = $RecipeID");
                    $image = $imgResult->fetch(PDO::FETCH_ASSOC);
                    $title = $titleResult->fetch(PDO::FETCH_ASSOC);
                    if ($image !== false) {
                        echo "<img class='title-image' src='".$image['ImageURL']."' alt='Picture of ".$title['Title']."'>";
                    }
                    ?>
                    <!-- <img class="title-image" src='/pictures/ApplePie.jpg' alt='Apple pie'> -->
            </div>
            <div class="recipe-card recipe-grid">
                <div class="column1">
                    <h2>Recipe card</h2>
                    <!--get prep time and servings from database-->
                    <?php global $pdo, $RecipeID;
                    $query = $pdo -> query("SELECT Time, Servings, Author FROM Recipe WHERE RecipeID = $RecipeID");
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    echo "<ul><li>Preparation time: ".$result['Time']." mins</li>";
                    echo "<li>Servings: ".$result['Servings']."</li>";
                    echo "<li>Source: <a href='".$result['Author']."'>".$result['Author']."</a></li></ul>";
                    ?>
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
                    <?php
                    global $pdo, $RecipeID;
                    $result = $pdo -> query("SELECT R.StepsRecipe FROM Recipe R WHERE RecipeID = $RecipeID");
                    $description = $result->fetch(PDO::FETCH_ASSOC);
                    echo "<br>";
                    echo $description['StepsRecipe'];
                    ?>
                </div>
                <div class="column2">
                <?php
                    global $pdo, $RecipeID, $UserID;
                    $savedStatus = 0;
                    if ($UserID !== NULL) {
                        $status = $pdo->query("SELECT SavedStatus FROM UserRecipe WHERE UserRecipe.UserID = $UserID AND UserRecipe.RecipeID = $RecipeID");
                        $stat = $status->fetch(PDO::FETCH_ASSOC);
                        if ($stat["SavedStatus"] === 1) {
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
        <h2>Comment section</h2>
        <div class="new-comment">
            <form method="post" action="place-comment.php">
                <label>New comment:</label>
                <br>
                <textarea maxlength='1024' id="commentinput" placeholder="Write your comment..."></textarea>
                <div id="characterCount">0 / 1024</div>

                <script>
                    $(document).ready(function () {
                        var $textArea = $('#commentinput');
                        var $characterCount = $('#characterCount');

                        $textArea.on('input', function () {
                            var currentLength = $textArea.val().length;
                            var maxLength = parseInt($textArea.attr('maxlength'));

                            $characterCount.text(currentLength + ' / ' + maxLength);
                        });
                    });
                </script>
                <br>
                <input id='postComment' type="submit" value="Post">
            </form>
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
                echo "<p class='comment-info'>" . $commenter['Username']. " commented on " . $id["CreatedAt"]."</p>";
                echo "<p class='comment-text'>".$id["CommentText"]."</p>";
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
    <script src = "SaveScript.js"></script>
</body>
</html>
