<?php
require_once('../../db.php'); 

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Проверяем наличие параметра favorite_user_ids в массиве $_GET
    if (isset($_GET['favorite_user_ids'])) {
        $favoriteUserIds = explode(',', $_GET['favorite_user_ids']);
        $favoriteUserIds = array_map('intval', $favoriteUserIds);

        // Подготовим метку параметра для каждого идентификатора пользователя
        $placeholders = implode(',', array_fill(0, count($favoriteUserIds), '?'));

        $query = "SELECT *
                  FROM users u
                  LEFT JOIN users_profile up ON u.id = up.user_p_id
                  LEFT JOIN users_inf ui ON u.id = ui.user_id
                  WHERE u.id IN ($placeholders)";

        $stmt = $conn->prepare($query);

        // Привязываем параметры
        $types = str_repeat('i', count($favoriteUserIds));
        $stmt->bind_param($types, ...$favoriteUserIds);

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
    } else {
        echo json_encode(['success' => false, 'message' => 'Отсутствует параметр favorite_user_ids в URL']);
        exit();
    }
}
?>
