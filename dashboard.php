<?php
include("connect.php");
include("query.php");

// Function to format the order status
function formatStatus($status)
{
    switch ($status) {
        case 0:
            return "OTW";
        case 1:
            return "Received";
        case 2:
            return "Req Return";
        case 3:
            return "Return Approved";
        case 4:
            return "Return Rejected";
        default:
            return "Unknown";
    }
}

$totalOrdersResult = $con->query("SELECT COUNT(*) as total_orders FROM orders");
$totalOrders = $totalOrdersResult->fetch_assoc()['total_orders'];

$totalRevenueResult = $con->query("SELECT SUM(total_amount) as total_revenue FROM orders");
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

$orderStatusSummaryResult = $con->query("
    SELECT 
        SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as otw,
        SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as received,
        SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as req_return,
        SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as return_approved,
        SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as return_rejected
    FROM orders
");
$orderStatusSummary = $orderStatusSummaryResult->fetch_assoc();

$recentOrdersResult = $con->query("SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            width: 200px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .recent-orders,
        .flash-deals {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

    </style>
</head>

<body>
    <h1>E-commerce Dashboard</h1>
    <div class="dashboard">
        <div class="card">
            <h2>Total Orders</h2>
            <p><?php echo $totalOrders; ?></p>
        </div>
        <div class="card">
            <h2>Total Revenue</h2>
            <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
        </div>
        <div class="card">
            <h2>Order Status</h2>
            <p>OTW: <?php echo $orderStatusSummary['otw']; ?></p>
            <p>Received: <?php echo $orderStatusSummary['received']; ?></p>
            <p>Req Return: <?php echo $orderStatusSummary['req_return']; ?></p>
            <p>Return Approved: <?php echo $orderStatusSummary['return_approved']; ?></p>
            <p>Return Rejected: <?php echo $orderStatusSummary['return_rejected']; ?></p>
        </div>
    </div>

    <div class="recent-orders">
        <h2>Recent Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Products</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $recentOrdersResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td>{$row['customer_id']}</td>";

                    // Fetch products and quantities
                    $productIds = explode(',', $row['product_id']);
                    $quantities = explode(',', $row['order_quantity']);
                    $products = [];

                    foreach ($productIds as $index => $productId) {
                        $productResult = $con->query("SELECT * FROM items WHERE ItemID = {$productId}");
                        if ($productResult->num_rows > 0) {
                            $product = $productResult->fetch_assoc();
                            $products[] = "{$product['ItemName']} (Qty: {$quantities[$index]})";
                        }
                    }
                    echo "<td>" . implode('<br> ', $products) . "</td>";
                    $formattedDate = date('F j, Y', strtotime($row['order_date']));
                    echo "<td>{$formattedDate}</td>";
                    echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                    echo "<td>" . formatStatus($row['status']) . "</td>";
                    echo "<td>{$row['rating']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    



</body>

</html>

<?php
$con->close();
?>