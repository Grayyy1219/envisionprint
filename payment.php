<?php
session_start();
include 'connect.php';
include 'query.php';

if (!isset($_SESSION['selectedItems'])) {
    die("No items selected for purchase.");
}

$selectedItems = $_SESSION['selectedItems'];

// Prepare the query to fetch selected items
$getSelectedItemsQuery = "SELECT items.ItemID, items.ItemName, items.Price, cart.Quantity, cart.upload 
FROM cart INNER JOIN items ON cart.ItemID = items.ItemID 
WHERE cart.customer_id = ? AND cart.cart_id IN ($selectedItems)";

$stmtGetSelectedItems = mysqli_prepare($con, $getSelectedItemsQuery);
mysqli_stmt_bind_param($stmtGetSelectedItems, "i", $UserID);
mysqli_stmt_execute($stmtGetSelectedItems);
$result = mysqli_stmt_get_result($stmtGetSelectedItems);

if (!$result) {
    die("Error retrieving selected items: " . mysqli_error($con));
}

$totalPurchaseValue = 0;
$productIDs = [];
$quantities = [];
$uploads = [];

while ($row = mysqli_fetch_assoc($result)) {
    $totalPurchaseValue += $row['Quantity'] * $row['Price'];
    $productIDs[] = $row['ItemID'];
    $quantities[] = $row['Quantity'];
    $uploads[] = $row['upload'];
}

// Concatenate product IDs, quantities, and uploads
$productIDsString = implode(',', $productIDs);
$quantitiesString = implode(',', $quantities);
$uploadsString = implode(',', $uploads);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentMode = $_POST['paymentMode'] ?? 'Cash On Delivery'; // Default value if not set

    $totalAmount = $_SESSION['discountedPrice'] ?? $totalPurchaseValue;

    // Insert order
    $saveOrderQuery = "INSERT INTO orders (customer_id, order_date, total_amount, order_quantity, product_id, upload) VALUES (?, CURRENT_TIMESTAMP, ?, ?, ?, ?)";
    $stmtSaveOrder = mysqli_prepare($con, $saveOrderQuery);

    if ($stmtSaveOrder) {
        $orderQuantity = array_sum($quantities);
        mysqli_stmt_bind_param($stmtSaveOrder, "idsss", $UserID, $totalAmount, $quantitiesString, $productIDsString, $uploadsString);
        mysqli_stmt_execute($stmtSaveOrder);
        $orderId = mysqli_insert_id($con);
        mysqli_stmt_close($stmtSaveOrder);
    } else {
        die("Error preparing order query: " . mysqli_error($con));
    }

    // Insert payment details
    $savePaymentQuery = "INSERT INTO payment (order_id, customer_id, payment_mode, amount_paid) VALUES (?, ?, ?, ?)";
    $stmtSavePayment = mysqli_prepare($con, $savePaymentQuery);

    if ($stmtSavePayment) {
        mysqli_stmt_bind_param($stmtSavePayment, "iisd", $orderId, $UserID, $paymentMode, $totalAmount);
        mysqli_stmt_execute($stmtSavePayment);
        mysqli_stmt_close($stmtSavePayment);
    } else {
        die("Error preparing payment details statement: " . mysqli_error($con));
    }

    // Update items
    foreach ($productIDs as $index => $productId) {
        $quantity = $quantities[$index];

        $updateItemsQuery = "UPDATE items SET Quantity = Quantity - ?, Solds = Solds + ? WHERE ItemID = ?";
        $stmtUpdateItems = mysqli_prepare($con, $updateItemsQuery);

        if ($stmtUpdateItems) {
            mysqli_stmt_bind_param($stmtUpdateItems, "iii", $quantity, $quantity, $productId);
            mysqli_stmt_execute($stmtUpdateItems);
            mysqli_stmt_close($stmtUpdateItems);
        } else {
            die("Error updating item quantities: " . mysqli_error($con));
        }
    }

    header('Location: orderdone.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/payment.css">
</head>

<body>
    <?php include("header.php"); ?>
    <div class="popupd">
        <div class="done">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="payment-form">
                <div class="form-group">
                    <label for="paymentMode">Payment Mode:</label>
                    <span class="tooltiptext">Select your preferred payment method.</span>
                    <div class="method_img">
                        <?php
                        $sql = "SELECT * FROM paymethod";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<img src="' . $row["method_img"] . '" alt=""> ';
                            }
                        }
                        ?>
                    </div>
                    <select name="paymentMode" id="paymentMode" required>
                        <option value="Cash On Delivery">Cash On Delivery</option>
                        <?php
                        $sql = "SELECT * FROM paymethod";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["method_name"] . '">' . $row["method_name"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="payment-button">
                    <button class="buybtn" type="submit">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
    <?php include("footer.html"); ?>
</body>

</html>