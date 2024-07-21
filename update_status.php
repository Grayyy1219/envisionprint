<?php
include("connect.php");
include("query.php");

if (isset($_GET['status']) && isset($_GET['orderid'])) {
    $status = intval($_GET['status']);
    $order_id = intval($_GET['orderid']);

    if ($status == 3 || $status == 4) {
        // Prepare and execute the SQL statement to update order status
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
            // Prepare and execute the SQL statement to get product_id and order_quantity
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

            // Ensure both arrays have the same length
            if (count($product_ids) !== count($order_quantities)) {
                die('Mismatch between product IDs and quantities.');
            }

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = intval($product_ids[$i]);
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

        $successMessage = ($status == 3) ? "Request Approved and product quantities updated." : "Request Canceled.";
        echo "<script>
            alert('$successMessage');
            window.location.href = 'admin.php?return';
          </script>";
    } else {
        $errorMessage = "Invalid status value.";
        echo "<script>
            alert('$errorMessage');
            window.location.href = 'admin.php?return';
          </script>";
    }
} else {
    $noUserIdMessage = "Status or Order ID not provided.";
    echo "<script>
            alert('$noUserIdMessage');
            window.location.href = 'admin.php?return';
          </script>";
}

// Close connection
$con->close();
