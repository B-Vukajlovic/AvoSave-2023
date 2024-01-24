<?php
/* $servername = "localhost";
$username = "username";
$password = "password";

try {
  $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}*/

$ingredients = [
    'fruits' => ["Apple", "Banana", "Cherry"],
    'vegetables' => ["Carrot", "Broccoli", "Spinach"],
    'meatAndFish' => ["Chicken", "Beef", "Salmon"],
];

$category = $_GET['category'] ?? 'fruits';
$response = isset($ingredients[$category]) ? $ingredients[$category] : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ingredientpage-style.css">
    <title>Pick Ingredients</title>
</head>
<body class="body">
    <div class="logoCombo">
        <img src="/Webtechnologie-Website-2023-UvA/VIdeos/avosave_logo-removebg-preview.png" class="logo">
        <img src="/Webtechnologie-Website-2023-UvA/VIdeos/Logo-PhotoRoom(3).png" class="logo">
        <nav class="navbar">
            <ul id="pageNav">
                <li class="pageTraversal" id="home"><a href="#">Home</a></li>
                <li class="pageTraversal" id="search"><a href="#">Search</a></li>
            </ul>
            <ul id="accountNav">
                <li class="pageTraversal" id="login"><a href="#">Login</a></li>
            </ul>
        </nav>
    </div>

    <div class="center">
        <h1>Choose ingredients to include</h1>
    </div>

    <section class="tools">
        <div class="search-bar">
            <input type="text" placeholder="Search an ingredient..." class="input-search-bar">
        </div>
        <div id="dropdown">
            <select id="dropdown-content">
                <?php foreach ($ingredients as $key => $value): ?>
                    <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars(ucfirst($key)); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="ingredients-container">
            <?php foreach ($response as $ingredient): ?>
                <button class="ingredient-button"><?php echo htmlspecialchars($ingredient); ?></button>
            <?php endforeach; ?>
        </div>

        <div>
            <button class="next" onclick="window.location.href = 'recipe-overview.php';">Next</button>
        </div>
    </section>
    <script src="ingredientpage-script.js"></script>
</body>
</html>
