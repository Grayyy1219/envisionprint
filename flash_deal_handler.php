<?php
include("connect.php");
include("query.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $new_item_name = $_POST['new_item_name'];
    $new_item_price = $_POST['new_item_price'];
    $discounted_price = $_POST['discounted_price'];
    $quantity = $_POST['quantity'];

    if ($_FILES['item_image']['size'] > 0) {
        $name = $_FILES['item_image']['name'];
        $tmp_name = $_FILES['item_image']['tmp_name'];
        $item_image = "upload/item/$name";
        move_uploaded_file($tmp_name, $item_image);
    }

    if (!empty($item_id)) {
        $query = "UPDATE items SET oldprice = price, price = ?, onsale = 1   WHERE ItemID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("di", $discounted_price, $item_id);
    } else if (!empty($new_item_name) && !empty($new_item_price)) {
        $query = "INSERT INTO items (ItemName, Price, oldprice, onsale, ItemImg, Quantity) VALUES (?, ?, ?, 1, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sddsi", $new_item_name, $discounted_price, $new_item_price,  $item_image, $quantity,);
    } else {
        echo "Please select an existing item or provide details for a new item.";
        exit;
    }

    if ($stmt->execute()) {
        echo '<script>alert("Deals created successfully");window.location.href = "admin.php?deals";</script>';
    } else {
        echo "Error updating item: " . $stmt->error;
    }
}
