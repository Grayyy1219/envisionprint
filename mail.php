<?php
include("connect.php");
include("query.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\envisionprint\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\envisionprint\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\envisionprint\PHPMailer\src\SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply.thebookhaven@gmail.com';
    $mail->Password = 'glyt mguu ymqy noks';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    // Recipients
    $mail->setFrom("$email", 'EnVision Print');
    $mail->addAddress("$email", '');

    $verificationCode = rand(10000, 99999);
    $sql = "UPDATE users SET verification_code = '$verificationCode' WHERE email = '$email'";
    mysqli_query($con, $sql);

    $verificationLink = "http://localhost/envisionprint/verify.php?code=$verificationCode";

    $mail->isHTML(true);
    $mail->Subject = 'Confirm Your EnVision Print Account - Dive into Med Bliss!';
    $mail->Body = "Thank you for creating an account with EnVision Print!. To keep your account secure, please verify your email address by clicking on the following link: <br> <b><a href='$verificationLink'>Verify Your Email</a></b> <br> Your verification code is: <h1>$verificationCode</h1> <br> If you did not create an account with EnVision Print, please disregard this email.<br><br>Thank you for choosing EnVision Print and happy shopping!";
    $mail->AltBody = 'Thank you for creating an account with EnVision Print!. To keep your account secure, please verify your email address using the provided verification link and code. If you did not sign up, please disregard this email.';


    // Send the email
    $mail->send();

    echo '<script>alert("Verification link sent to you email!");</script>';
    echo '<script>window.history.back();</script>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
