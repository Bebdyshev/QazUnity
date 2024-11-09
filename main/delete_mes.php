<?php
require_once('../regprocces/db.php'); // Assuming your database connection file is in this location

if (isset($_GET['id'])) {
    $messageId = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users_mes WHERE id = ?");
    $stmt->bind_param('i', $messageId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Message deleted successfully";
    } else {
        echo "Failed to delete message";
    }
} else {
    echo "Invalid request";
}

$stmt->close();
$conn->close();
?>
