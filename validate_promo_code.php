<?php
include("connect.php");

$promoCode = $_POST['promoCode'];

$checkPromoCodeQuery = "SELECT discount FROM promo_codes WHERE code = ?";
$stmt = mysqli_prepare($con, $checkPromoCodeQuery);
mysqli_stmt_bind_param($stmt, "s", $promoCode);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(array("valid" => true, "discount" => $row['discount']));
} else {
    echo json_encode(array("valid" => false));
}
