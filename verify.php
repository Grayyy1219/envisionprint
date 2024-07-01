<?php
include("connect.php");

$verificationCode = $_GET['code'];

if (!empty($verificationCode)) {
    $stmt = $con->prepare("UPDATE users SET verification = 1 WHERE verification_code = ?");
    $stmt->bind_param("s", $verificationCode);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Your email has been successfully verified.\n\nWelcome to EnVision Print community!\nHappy Shopping!\n\nThank you for choosing EnVision Print.");</script>';
            echo '<script>window.location.href = "landingpage.php";</script>';
        } else {
            echo '<script>alert("Invalid verification code. Please try again.");</script>';
            echo '<script>window.history.back();</script>';
        }
    }
    $stmt->close();
} else {
    echo "Invalid verification code";
}
$con->close();
