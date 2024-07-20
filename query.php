<?php
$queryUser = mysqli_query($con, "SELECT * FROM currentuser WHERE UserID = 1");
$rowUser = mysqli_fetch_assoc($queryUser);

$location = $rowUser["profile"];
$username = $rowUser["username"];
$FName = $rowUser["FName"];
$email = $rowUser["email"];
$address = $rowUser['address'];
$phone = $rowUser['phone'];
if ($username != 0) {
    $queryUser = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
    $rowUser = mysqli_fetch_assoc($queryUser);
    $password = $rowUser["password"];
    $verification = $rowUser["verification"];
    $block = $rowUser["block"];
    $on = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
    $rowon = mysqli_fetch_assoc($on);
    $UserID = $rowon["UserID"];
    $query69 = mysqli_query($con, "SELECT COUNT(cart_id) AS count from cart WHERE customer_id = $UserID");
    $row69 = mysqli_fetch_assoc($query69);
    $cartcount = $row69["count"];
} else {
    $verification = '0';
    $block = '0';
}


$queryPage = mysqli_query($con, "SELECT * FROM page WHERE ItemID IN (1, 2, 3, 4, 5)");
while ($rowPage = mysqli_fetch_assoc($queryPage)) {
    if ($rowPage["ItemID"] == 1) {
        $logo = $rowPage["value"];
    } elseif ($rowPage["ItemID"] == 2) {
        $companyname = $rowPage["value"];
    } elseif ($rowPage["ItemID"] == 3) {
        $backgroundimg = $rowPage["value"];
    } elseif ($rowPage["ItemID"] == 4) {
        $backgroundcolor = $rowPage["value"];
    } elseif ($rowPage["ItemID"] == 5) {
        $color = $rowPage["value"];
    }
}
$queryAdmin = mysqli_query($con, "SELECT * FROM users WHERE UserID = '1'");
$rowUser2 = mysqli_fetch_assoc($queryAdmin);
$hashedadminpassword = $rowUser2["password"];
$alocation = $rowUser2["profile"];
$ausername = $rowUser2["username"];
$aFName = $rowUser2["FName"];
$aemail = $rowUser2["email"];
$aaddress = $rowUser2['address'];
$aphone = $rowUser2['phone'];
echo "
<link rel='icon' href='css/img/logo.ico'>
<style>
:root {
    --text: $color;
    --background: #ffffff;
    --primary: $backgroundcolor;
    --secondary: #be2aec;
    --btext: #ffffff;
}
p,h1{
color:  var(--text);
}
</style>
<script>
    function backref() {
        window.location.href = document.referrer;
    }
</script>";
