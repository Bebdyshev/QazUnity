<?php
require_once('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["id"];
    $place = $_POST["place"];
    $exp = $_POST["exp"];
    $help = $_POST["help"];

    $helpList = implode(",", $help);

    if ($conn) {
        $check_query = "SELECT * FROM users_inf WHERE user_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $update_query = "UPDATE users_inf SET help = ?, place = ?, experience = ? WHERE user_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssi", $helpList, $place, $exp, $user_id);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $user_id;
                header("Location: ../main/community.php");
                exit();
            } else {
                header("Location: ../main/home.php?error=update");
                exit();
            }
        } else {
            $insert_query = "INSERT INTO users_inf (help, place, experience, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssi", $helpList, $place, $exp, $user_id);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $user_id;
                header("Location: ../main/community.php");
                exit();
            } else {
                header("Location: ../main/home.php?error=insert");
                exit();
            }
        }
    }
}
?>
