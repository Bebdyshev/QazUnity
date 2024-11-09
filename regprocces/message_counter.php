<?php

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    require_once('../regprocces/db.php');

    $count_other_messages_query = "SELECT COUNT(*) AS count 
        FROM users_mes 
        WHERE (user_send_id != ? AND user_rec_id = ?)";
    $stmt_count = $conn->prepare($count_other_messages_query);
    $stmt_count->bind_param('ii', $user_id, $user_id);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $count_other_messages = $row_count['count'];
}
?>
