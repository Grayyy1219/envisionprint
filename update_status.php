<?php
include("connect.php");
include("query.php");

if (isset($_GET['status']) && isset($_GET['orderid'])) {
    $status = intval($_GET['status']);
    $order_id = intval($_GET['orderid']);

    $statusMessages = [
        -2 => "Order has been canceled.",
        -1 => "Order is now being processed.",
        0 => "Order is marked as To be Received.",
        1 => "Order received and product quantities updated.",
        2 => "Return request is pending.",
        3 => "Return approved and product quantities updated.",
        4 => "Return request rejected."
    ];

    $validStatuses = [-2, -1, 0, 1, 2, 3, 4];

    if (in_array($status, $validStatuses)) {
        // Update order status
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
        }
        $stmt->bind_param("ii", $status, $order_id);
        if (!$stmt->execute()) {
            $errorMessage = "Error updating order status: " . htmlspecialchars($stmt->error);
            echo "<script>
                alert('$errorMessage');
                window.location.href = 'admin.php?return';
              </script>";
            $stmt->close();
            exit();
        }
        $stmt->close();

        if ($status == 3) {
            $sql = "SELECT product_id, order_quantity FROM orders WHERE order_id = ?";
            $stmt = $con->prepare($sql);
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($con->error));
            }
            $stmt->bind_param("i", $order_id);
            if (!$stmt->execute()) {
                $errorMessage = "Error retrieving order details: " . htmlspecialchars($stmt->error);
                echo "<script>
                    alert('$errorMessage');
                    window.location.href = 'admin.php?return';
                  </script>";
                $stmt->close();
                exit();
            }
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $product_ids = explode(',', $row['product_id']);
            $order_quantities = explode(',', $row['order_quantity']);

            if (count($product_ids) !== count($order_quantities)) {
                die('Mismatch between product IDs and quantities.');
            }

            foreach ($product_ids as $i => $product_id) {
                $product_id = intval($product_id);
                $order_quantity = intval($order_quantities[$i]);

                $sql = "UPDATE items SET Quantity = Quantity + ? WHERE ItemID = ?";
                $stmt_update = $con->prepare($sql);
                if ($stmt_update === false) {
                    die('Prepare failed: ' . htmlspecialchars($con->error));
                }
                $stmt_update->bind_param("ii", $order_quantity, $product_id);
                if (!$stmt_update->execute()) {
                    $errorMessage = "Error updating product quantity for product ID $product_id: " . htmlspecialchars($stmt_update->error);
                    echo "<script>
                        alert('$errorMessage');
                        window.location.href = 'admin.php?return';
                      </script>";
                }
                $stmt_update->close();
            }
            $result->free();
        }

        $successMessage = $statusMessages[$status];
        echo "<script>
        alert('$successMessage');
        backref();
      </script>";
    } else {
        $errorMessage = "Invalid status value.";
        echo "<script>
            alert('$errorMessage');
            window.history.back();
          </script>";
    }
} else {
    $noUserIdMessage = "Status or Order ID not provided.";
    echo "<script>
        alert('$noUserIdMessage');
        window.history.back();
      </script>";
}

$con->close();
