<?php
include("connect.php");
include("query.php");

if (isset($_GET['status']) && isset($_GET['orderid'])) {
    $status = intval($_GET['status']);
    $order_id = intval($_GET['orderid']);

    if ($status == 3 || $status == 4) {
        $sql = "UPDATE orders SET status= ? WHERE order_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $status, $order_id);

        if ($stmt->execute()) {
            $successMessage = ($status == 3) ? "Request Approved." : "Request Canceled.";
            echo "<script>
                alert('$successMessage');
                window.location.href = 'admin.php?return';
              </script>";
        } else {
            $errorMessage = "Error: " . htmlspecialchars($stmt->error);
            echo "<script>
                alert('$errorMessage');
                window.location.href = 'admin.php?return';
              </script>";
        }
        $stmt->close();
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
