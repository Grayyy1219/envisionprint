<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    if (is_numeric($cart_id) && is_numeric($quantity) && $quantity > 0) {
        $updateQuery = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id";
        if (mysqli_query($con, $updateQuery)) {
            echo "Quantity updated successfully";
        } else {
            echo "Error updating quantity: " . mysqli_error($con);
        }
    } else {
        echo "Invalid input";
    }
}
