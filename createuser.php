<?php
include("connect.php");

$fname = $_POST['txtfname'];
$username = $_POST['txtusername'];
$lname = $_POST['txtlname'];
$password = $_POST['txtpassword'];
$email = $_POST['txtemail'];
$profile = 'css/img/new.png';
$fullname = "$fname $lname";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$checkQuery = "SELECT username, email FROM users WHERE username = ?";
$checkStmt = mysqli_prepare($con, $checkQuery);
mysqli_stmt_bind_param($checkStmt, "s", $username);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    mysqli_stmt_close($checkStmt);
    mysqli_close($con);
    echo '<script>alert("Username or email already exists. Please choose a different one.");</script>';
    echo '<script>window.history.back();</script>';
} else {
    mysqli_stmt_close($checkStmt);

    $sql = "INSERT INTO users (Fname, username, password, email, profile) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $fullname, $username, $hashedPassword, $email, $profile);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($con);

    echo '<script>alert("Signup Successfully!");</script>';
    echo '<script>window.location.href = "Landingpage.php";</script>';
}
