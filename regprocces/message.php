<?php
use PHPMailer\PHPmailer\PHPmailer;
use PHPMailer\PHPmailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require_once('db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_rec_id = $_POST["user_rec_id"];
    $user_send_id = $_POST["user_send_id"];
    $message = $_POST["message"];
    $title = $_POST["title"];

    if ($conn) {

        $fetch_recipient_details_query = "SELECT name, surname, email FROM users WHERE id = ?";
        $stmt_fetch_recipient_details = $conn->prepare($fetch_recipient_details_query);
        $stmt_fetch_recipient_details->bind_param("s", $user_rec_id);
        $stmt_fetch_recipient_details->execute();
        $stmt_fetch_recipient_details->bind_result($recipient_name, $recipient_surname, $recipient_email);
        $stmt_fetch_recipient_details->fetch(); 
        $stmt_fetch_recipient_details->close();

        $fetch_sender_details_query = "SELECT name, surname, email FROM users WHERE id = ?";
        $stmt_fetch_sender_details = $conn->prepare($fetch_sender_details_query);
        $stmt_fetch_sender_details->bind_param("s", $user_send_id);
        $stmt_fetch_sender_details->execute();
        $stmt_fetch_sender_details->bind_result($sender_name, $sender_surname, $sender_email);
        $stmt_fetch_sender_details->fetch(); 
        $stmt_fetch_sender_details->close();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'qazunityoff@gmail.com';
        $mail->Password = 'qabcllwhzolvxbhw';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom("qazunityoff@gmail.com");
        $mail->addAddress($recipient_email);
        $mail->isHTML(true);

        $body = "
            <h2>Message from <a style='color:#7011ce; text-decoration: none;' href='http://localhost/phpscript/main/profile.php?user_id=$user_send_id'>$sender_name $sender_surname</a></h2>
            <b>Email: $sender_email</b>
            <p>Message:</p>
            <p>$message</p>
        ";

        $subject = "
            New massage: $title 
        ";

        $mail->Subject = $subject;
        $mail->Body = $body;

        $insert_user_query = "INSERT INTO users_mes (user_rec_id, user_send_id, message, title) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_user_query);

        if ($stmt) {
            $stmt->bind_param("ssss", $user_rec_id, $user_send_id, $message, $title);
            if ($stmt->execute()) {
                try {
                    $mail->send();
                    header("Location: ../main/community.php");
                    exit();
                } catch (Exception $e) {
                    header("Location: ../main/home.php?error=email");
                    exit();
                }
            } else {
                header("Location: ../main/home.php?error=insert");
                exit();
            }
        } else {
            header("Location: ../main/home.php?error=prepare");
            exit();
        }
    } else {
        header("Location: ../main/home.php?error=database");
        exit();
    }
}
?>
