<?php
require_once('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $pass = $_POST["pass"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $activity = $_POST["activity"];
    $carier = $_POST["carier"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $file_name = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "images/" . $file_name;

        $check_email_query = "SELECT * FROM users WHERE email='$email'";
        $check_email_result = $conn->query($check_email_query);

        if ($check_email_result->num_rows > 0) {
            echo "Электронная почта уже занята. Пожалуйста, выберите другую почту.";
            exit();
        }

        $activityList = implode(",", $activity);

        $insert_user_query = "INSERT INTO users (name, surname, email, pass, status, multi, carier, image) VALUES ('$name', '$surname', '$email', '$pass', '$status', '$activityList', '$carier', '$file_name')";

        if (move_uploaded_file($tempname, $folder)) {
            if ($conn->query($insert_user_query) === TRUE) {
                $inserted_user_id = $conn->insert_id;
                $_SESSION['id'] = $inserted_user_id;

                $insert_users_inf_query = "INSERT INTO users_inf (user_id) VALUES ('$inserted_user_id')";
                if ($conn->query($insert_users_inf_query) === FALSE) {
                    echo "Ошибка при создании записи в таблице users_inf: " . $conn->error;
                    exit();
                }

                $insert_user_profile_query = "INSERT INTO users_profile (user_p_id) VALUES ('$inserted_user_id')";
                if ($conn->query($insert_user_profile_query) === FALSE) {
                    echo "Ошибка при создании записи в таблице user_profile: " . $conn->error;
                    exit();
                }

                header("Location: ../main/home.php");
                exit();
            } else {
                header("Location: ../registration.php");
                exit();
            }
        } else {
            echo "Произошла ошибка при загрузке файла.";
        }
    } else {
        echo "Файл не был загружен или произошла ошибка во время загрузки.";
    }
}
?>
