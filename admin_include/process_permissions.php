<?php
require_once('../includes/pdo-connect.php');
require_once('../includes/config_session.php');

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'UserID' ] ) && isset( $_POST[ 'AdminStatusRequest' ] ) ) {
    $currentUserID = $_SESSION["userid"];
    $userID = $_POST[ 'UserID' ];
    $adminStatusRequest = $_POST['AdminStatusRequest'];
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
    error_log("testjioewij");
}

