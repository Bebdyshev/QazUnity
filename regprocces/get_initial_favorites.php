<?php
session_start();

require_once('db.php');

$currentId = $_SESSION['id'];

$checkFavoriteQuery = "SELECT favorites FROM users_inf WHERE user_id = ?";
$stmtCheck = $conn->prepare($checkFavoriteQuery);
$stmtCheck->bind_param('i', $currentId);
$stmtCheck->execute();
$stmtCheck->bind_result($favorites);
$stmtCheck->fetch();
$stmtCheck->close();

$favoritesArray = explode(',', $favorites);

$response = array(
    'favoritesArray' => $favoritesArray
);

echo json_encode($response);

$conn->close();
?>
