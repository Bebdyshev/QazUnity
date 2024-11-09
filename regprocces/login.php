<?php
require_once('db.php');

session_start();
echo "session started <br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    echo "email: " . $email . "<br> password: " . $pass . "<br>";

    if (empty($pass) || empty($email)) {
        echo "заполните все поля";
    } else {
        echo "login and pass arent empty<br>";
        
        $sql = "SELECT * FROM `users` WHERE email = ? AND pass = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $pass);
        $stmt->execute();
        if ($stmt->error) {
            echo "Ошибка SQL: " . $stmt->error;
            exit();
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];

            $usersQuery = "SELECT * FROM `users`";
            $usersResult = $conn->query($usersQuery);
            if ($usersResult->num_rows > 0) {
                echo "<h2>Список пользователей:</h2>";
                while ($userRow = $usersResult->fetch_assoc()) {
                    echo "ID: " . $userRow['id'] . " | Email: " . $userRow['email'] . "<br>";
                }
            } else {
                echo "Нет пользователей.";
            }

            echo "everything works correctly";
            // Убедитесь, что перенаправление происходит после всех выводов на экран
            header("Location:../main/home.php");
            exit();
        } else {
            echo "Нет результатов.";
        }
    }
}
?>
