<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $order_id = (int)$_POST['order_id'];

    if ($action == 'received') {
        $status = 1;  
    } elseif ($action == 'return') {
        $status = 2; 
    } else {
        echo "Invalid action.";
        exit();
    }

    $update_status_query = "UPDATE orders SET status = $status WHERE order_id = $order_id";
    if (mysqli_query($con, $update_status_query)) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating order status: " . mysqli_error($con);
    }
}
