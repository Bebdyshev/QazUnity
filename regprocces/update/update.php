<?php
require_once('../db.php'); // Подключение к базе данных, замените на свой файл подключения

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id']; // Получаем user_id из сессии

    function checkAndUpdateField($field, $fieldValue, $user_id, $table, $idTable, $conn) {
        $update_query = "UPDATE $table SET $field = ? WHERE $idTable = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $fieldValue, $user_id);
        if ($update_stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $update_stmt->close();
    }

    $success = false;

    if (isset($_POST['scale_uni'])) {
        $scale_uni = $_POST['scale_uni'];
        $success = checkAndUpdateField('scale_uni', $scale_uni, $user_id, 'users_profile', 'user_p_id', $conn);
    }

    if (isset($_POST['scale_work'])) {
        $scale_work = $_POST['scale_work'];
        $success = checkAndUpdateField('scale_work', $scale_work, $user_id, 'users_profile','user_p_id', $conn);
    }

    if (isset($_POST['major'])) {
        $major = $_POST['major'];
        $success = checkAndUpdateField('major', $major, $user_id,'users_profile', 'user_p_id', $conn);
    }

    if (isset($_POST['resources'])) {
        $resources = $_POST['resources'];
        $success = checkAndUpdateField('resources', $resources, $user_id, 'users_profile', 'user_p_id', $conn);
    }

    if (isset($_POST['advice'])) {
        $advice = $_POST['advice'];
        $success = checkAndUpdateField('advice', $advice, $user_id, 'users_profile', 'user_p_id', $conn);
    }

    if (isset($_POST['impact'])) {
        $impact = $_POST['impact'];
        $success = checkAndUpdateField('impact', $impact, $user_id, 'users_profile', 'user_p_id', $conn);
    }

    // dawdod

    if (isset($_POST['education'])) {
        $education = $_POST['education'];
        $success = checkAndUpdateField('education', $education, $user_id, 'users_profile','user_p_id',  $conn);
    }

    if (isset($_POST['majority'])) {
        $majority = $_POST['majority'];
        $success = checkAndUpdateField('majority', $majority, $user_id, 'users_profile','user_p_id',  $conn);
    }

    if (isset($_POST['work'])) {
        $work = $_POST['work'];
        $success = checkAndUpdateField('work', $work, $user_id, 'users_profile', 'user_p_id', $conn);
    }

    if (isset($_POST['role'])) {
        $role = $_POST['role'];
        $success = checkAndUpdateField('role', $role, $user_id, 'users_profile', 'user_p_id', $conn);
    }

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $success = checkAndUpdateField('name', $name, $user_id, 'users', 'id', $conn);
    }

    if (isset($_POST['surname'])) {
        $surname = $_POST['surname'];
        $success = checkAndUpdateField('surname', $surname, $user_id, 'users', 'id', $conn);
    }

    if (isset($_POST['experience'])) {
        $experience = $_POST['experience'];
        $success = checkAndUpdateField('experience', $experience, $user_id, 'users_inf', 'user_id', $conn);
    }

    if (isset($_POST['place'])) {
        $place = $_POST['place'];
        $success = checkAndUpdateField('place', $place, $user_id, 'users_inf', 'user_id', $conn);
    }

    if (isset($_POST['help']) && is_array($_POST['help'])) {
        $helpString = implode(',', $_POST['help']);
        $success = checkAndUpdateField('help', $helpString, $user_id, 'users_inf', 'user_id', $conn);
    }

    header('Content-Type: application/json');
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Данные успешно обработаны']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Произошла ошибка при обработке данных']);
    }
    exit();
}
?>