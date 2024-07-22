<?php
include("connect.php");

$UserID = $_POST['UserID'];
$first_name = $_POST['first_name'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone = $_POST['phone'];

if (isset($_POST["submit"])) {
    if ($_FILES['img']['size'] > 0) {
        $name = $_FILES['img']['name'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $location = "upload/profile/$name";
        move_uploaded_file($tmp_name, $location);
    } else {
        $queryRetrieveProfile = mysqli_query($con, "SELECT profile FROM users WHERE UserID = $UserID");
        $row = mysqli_fetch_assoc($queryRetrieveProfile);
        $location = $row['profile'];
    }

    $queryUpdateUsers = mysqli_query($con, "UPDATE users SET profile = '$location', FName = '$first_name',  Email = '$email', address ='$address', phone = '$phone' WHERE UserID = '$UserID'");

    echo '<script>alert("Profile updated successfully for User: ' . $targetFName . '");</script>';

    echo '<script>window.location.href = "admin.php?view_user";</script>';
}
