<header>
    <div class="logoBar">
        <li class="navText">AvoSave</li>
    </div>
    <nav class="navBar">
        <ul class="navSub" id="pageNav">
            <li class="pageTraversal" id="home"><a href="index.php">Home</a></li>
            <li class="pageTraversal" id="home"><a href="#aboutUs">Our goal</a></li>
        </ul>
        <ul class="navSub" id="accountNav">
            <?php if (isset($_SESSION["userid"])): ?>
                <li class="pageTraversal" id="logout">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="submit" value="Log-Out">
                    </form>
                </li>
                <li class="pageTraversal" id="profile"><a href="ProfilePage.php">Profile</a></li>
            <?php else: ?>
                <li class="pageTraversal" id="login"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
