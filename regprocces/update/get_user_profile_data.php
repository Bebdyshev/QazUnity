<?php
require_once('../db.php'); 

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_SESSION['url_id'];

    $query = "SELECT *
              FROM users u
              LEFT JOIN users_profile up ON u.id = up.user_p_id
              LEFT JOIN users_inf ui ON u.id = ui.user_id
              WHERE u.id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die(json_encode(['success' => false, 'message' => 'Ошибка выполнения запроса: ' . $stmt->error]));
    }

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $rows]);
        $stmt->close();
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Данные не найдены']);
        $stmt->close();
        exit();
    }
}
?>
