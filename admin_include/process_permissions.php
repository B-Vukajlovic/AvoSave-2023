<?php
// check if request is sent by an admin, check if the request is not made by the same admin 
// as the user whose permissions are being changed, and update the database accordingly
require_once('../includes/pdo-connect.php');
require_once('../includes/config_session.php');

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'userID' ] ) && isset( $_POST[ 'adminStatusRequest' ] ) ) {
    $currentUserID = $_SESSION["userID"];
    $userID = $_POST[ 'userID' ];
    $adminStatusRequest = $_POST['adminStatusRequest'];
    $userID = filter_var($userID, FILTER_VALIDATE_INT);
    $adminStatusRequest = filter_var($adminStatusRequest, FILTER_VALIDATE_INT);
    $sql = "SELECT isAdmin
            FROM User
            Where UserID = ? AND NOT UserID = ?";
    $stmt = $pdo->prepare( $sql );
    $stmt->execute([$userID, $currentUserID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result != $adminStatusRequest){
        $sql = "UPDATE User SET isAdmin=? WHERE UserID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$adminStatusRequest, $userID]);
    }
} else {
    error_log("Error with database.");
}

