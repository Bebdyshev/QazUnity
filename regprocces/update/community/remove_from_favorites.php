<?php
session_start();
require_once('../regprocces/db.php');

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $currentUserId = $_SESSION['id'];

    $deleteQuery = "DELETE FROM favorites WHERE user_id = $currentUserId AND favorite_user_id = $userId";
    $conn->query($deleteQuery);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
