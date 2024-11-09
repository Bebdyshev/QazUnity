<?php
session_start();
require_once('../regprocces/db.php');

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $currentUserId = $_SESSION['id'];

    $insertQuery = "INSERT INTO favorites (user_id, favorite_user_id) VALUES ($currentUserId, $userId)";
    $conn->query($insertQuery);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
