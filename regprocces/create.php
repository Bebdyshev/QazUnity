<?php
require_once('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $success = false;

    $user_id = $_SESSION['id'];
    $category = $_POST['category'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $text = $_POST['text'] ?? '';

    $insert_query = "INSERT INTO users_reddit (author_id, category, subject, text) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("isss", $user_id, $category, $subject, $text);
    if ($insert_stmt->execute()) {
        $success = true;
        header('Location: ../main/programms.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}
?>
