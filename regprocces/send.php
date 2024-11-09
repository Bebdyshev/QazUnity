<?php
use PHPMailer\PHPmailer\PHPmailer;
use PHPMailer\PHPmailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'qazunityoff@gmail.com';
        $mail->Password = 'qabcllwhzolvxbhw';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom("qazunityoff@gmail.com");

        $mail->addAddress($_POST["to-email"]);

        $mail->isHTML(true);

        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"];

        $mail->send();

        echo "<script>alert('Sent Successfully');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error sending email. Details: {$mail->ErrorInfo}');</script>";
    }
}
?>
