<?php
include("connect.php");
include("query.php");

$orderCountPerCategoryResult = $con->query("
    SELECT items.category, COUNT(orders.order_id) as order_count
    FROM orders
    JOIN items ON FIND_IN_SET(items.ItemID, orders.product_id) > 0
    GROUP BY items.category
");

if (!$orderCountPerCategoryResult) {
    die("Error retrieving order count per category: " . mysqli_error($con));
}

$orderCountPerCategory = [];
while ($row = $orderCountPerCategoryResult->fetch_assoc()) {
    $orderCountPerCategory[] = $row;
}

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
if (!$totalOrdersResult) {
    die("Error retrieving total orders: " . mysqli_error($con));
}
$totalOrders = $totalOrdersResult->fetch_assoc()['total_orders'];

$totalRevenueResult = $con->query("SELECT SUM(total_amount) as total_revenue FROM orders");
if (!$totalRevenueResult) {
    die("Error retrieving total revenue: " . mysqli_error($con));
}
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

if (!$orderStatusSummaryResult) {
    die("Error retrieving order status summary: " . mysqli_error($con));
}

$orderStatusSummary = $orderStatusSummaryResult->fetch_assoc();

$recentOrdersResult = $con->query("SELECT * FROM orders ORDER BY order_date DESC LIMIT 10");
if (!$recentOrdersResult) {
    die("Error retrieving recent orders: " . mysqli_error($con));
}

?>

<style>
    .row2 {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        width: 200px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        font-size: 12px;
    }

    .panel-body {
        padding: 15px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">E-commerce Dashboard</h3>
            </div>
            <div class="panel-body">
                <div class="row2">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Total Orders</h3>
                            </div>
                            <div class="panel-body">
                                <p><?php echo $totalOrders; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row2">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Order Count per Category</h3>
                            </div>
                            <div class="panel-body">
                                <?php foreach ($orderCountPerCategory as $categoryCount) : ?>
                                    <p><?php echo $categoryCount['category']; ?>: <?php echo $categoryCount['order_count']; ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row2">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Total Revenue</h3>
                            </div>
                            <div class="panel-body">
                                <p>₱<?php echo number_format($totalRevenue, 2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row2">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Order Status</h3>
                            </div>
                            <div class="panel-body">
                                <p>OTW: <?php echo $orderStatusSummary['otw']; ?></p>
                                <p>Received: <?php echo $orderStatusSummary['received']; ?></p>
                                <p>Req Return: <?php echo $orderStatusSummary['req_return']; ?></p>
                                <p>Return Approved: <?php echo $orderStatusSummary['return_approved']; ?></p>
                                <p>Return Rejected: <?php echo $orderStatusSummary['return_rejected']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Recent Orders</h3>
            </div>
            <div class="panel-body">
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

                            $productIds = explode(',', $row['product_id']);
                            $quantities = explode(',', $row['order_quantity']);
                            $uploads = explode(',', $row['upload']);
                            $products = [];

                            foreach ($productIds as $index => $productId) {
                                $productId = (int) $productId; // Ensure product ID is an integer
                                $productResult = $con->query("SELECT * FROM items WHERE ItemID = {$productId}");
                                if ($productResult->num_rows > 0) {
                                    $product = $productResult->fetch_assoc();
                                    $products[] = "{$product['ItemName']} (Qty: {$quantities[$index]}, Upload: {$uploads[$index]})";
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
        </div>
    </div>
</div>