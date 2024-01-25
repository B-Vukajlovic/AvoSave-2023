<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve entered values
    $entered_current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $repeat_password = $_POST["repeat_password"];
    //$current_password = rehash password?

    // Check validation
    if (empty($entered_current_password) || empty($new_password) || empty($repeat_password)) {
        echo "All fields are required.";
    } elseif ($new_password != $repeat_password) {
        echo "New password and repeat password do not match.";
    } /*elseif (entered_current_password != current_password){
        echo "The entered password is not correct"
    }
    */
    else {
        //TO DO: Get id with cookie
        $user_id = 1;
        //rehash password
        $rehashed_password = "a";
        $sql = "UPDATE User SET HashedPassword=? WHERE UserID=?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$rehashed_password, $user_id]);
        echo "Password changed successfully!";
    }
} else {
    exit();
}
?>
