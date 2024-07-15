<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'rating-') === 0) {
            $order_id = substr($key, strlen('rating-'));

            $rating = (int) htmlspecialchars($value);

            $update_order_query = "UPDATE orders SET rating = ? WHERE order_id = ?";
            $stmt_order = $con->prepare($update_order_query);
            $stmt_order->bind_param('ii', $rating, $order_id);
            $stmt_order->execute();
            $stmt_order->close();

            $get_product_ids_query = "SELECT product_id FROM orders WHERE order_id = ?";
            $stmt_products = $con->prepare($get_product_ids_query);
            $stmt_products->bind_param('i', $order_id);
            $stmt_products->execute();
            $stmt_products->bind_result($product_ids);

            if ($stmt_products->fetch()) {
                $product_id_array = explode(',', $product_ids);

                $stmt_products->close();

                foreach ($product_id_array as $product_id) {
                    $update_item_query = "UPDATE items SET rating = (rating * rating_count + ?) / (rating_count + 1), rating_count = rating_count + 1 WHERE ItemID = ?";
                    $stmt_item = $con->prepare($update_item_query);
                    $stmt_item->bind_param('ii', $rating, $product_id);
                    $stmt_item->execute();
                    $stmt_item->close();
                }
            }
        }
    }
    echo '<script>';
    echo 'alert("Thankyou for your feedback.");';
    echo 'window.location.href = "history.php";';
    echo '</script>';
    exit();
}
