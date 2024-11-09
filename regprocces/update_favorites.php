<?php
session_start();

$currentId = $_SESSION['id'];

if (isset($_POST['user_id'])) {
    $favoriteUserId = $_POST['user_id'];
} else {
    $favoriteUserId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
}

if ($favoriteUserId === null) {
    echo 'Invalid request: user_id not provided';
    exit;
}

require_once('db.php');

$checkFavoriteQuery = "SELECT favorites FROM users_inf WHERE user_id = ?";
$stmtCheck = $conn->prepare($checkFavoriteQuery);
$stmtCheck->bind_param('i', $currentId);
$stmtCheck->execute();
$stmtCheck->bind_result($favorites);
$stmtCheck->fetch();
$stmtCheck->close();

$favoritesArray = explode(',', $favorites);

if (in_array($favoriteUserId, $favoritesArray)) {
    $newFavoritesArray = array_diff($favoritesArray, array($favoriteUserId));
    $newFavorites = implode(',', $newFavoritesArray);

    $updateQuery = "UPDATE users_inf SET favorites = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $newFavorites, $currentId);
} else {
    $favoritesArray[] = $favoriteUserId;
    $favorites = implode(',', $favoritesArray);

    $updateQuery = "UPDATE users_inf SET favorites = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $favorites, $currentId);
}

if ($stmt->execute()) {
    $stmtCheck = $conn->prepare($checkFavoriteQuery);
    $stmtCheck->bind_param('i', $currentId);
    $stmtCheck->execute();
    $stmtCheck->bind_result($updatedFavorites);
    $stmtCheck->fetch();
    $stmtCheck->close();

    $updatedFavoritesArray = explode(',', $updatedFavorites);

    $response = array(
        'status' => 'success',
        'isFavorite' => in_array($favoriteUserId, $updatedFavoritesArray),
        'favoritesArray' => $updatedFavoritesArray
    );
    echo json_encode($response);
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Failed to update favorites'
    );
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
