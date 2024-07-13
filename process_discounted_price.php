<?php
session_start();

$discountedPrice = isset($_POST['discountedPrice']) ? $_POST['discountedPrice'] : null;

if ($discountedPrice !== null) {
    $_SESSION['discountedPrice'] = $discountedPrice;

    echo json_encode(array('success' => true, 'message' => 'Discounted price received successfully.'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Discounted price not received.'));
}
