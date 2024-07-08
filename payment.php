<?php
session_start();
include 'connect.php';
include 'query.php';

if (!isset($_SESSION['selectedItems'])) {
    echo "No items selected for purchase.";
    exit();
}

$selectedItems = $_SESSION['selectedItems'];

$getSelectedItemsQuery = "SELECT items.ItemID, items.ItemName, items.Price, cart.Quantity FROM cart 
INNER JOIN items ON cart.ItemID = items.ItemID 
 WHERE cart.customer_id = ? AND cart.cart_id IN ($selectedItems)";

$stmtGetSelectedItems = mysqli_prepare($con, $getSelectedItemsQuery);
mysqli_stmt_bind_param($stmtGetSelectedItems, "i", $UserID);
mysqli_stmt_execute($stmtGetSelectedItems);
$result = mysqli_stmt_get_result($stmtGetSelectedItems);

if (!$result) {
    echo "Error retrieving selected items: " . mysqli_error($con);
    exit();
}

$totalPurchaseValue = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $totalPurchaseValue += $row['Quantity'] * $row['Price'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentMode = isset($_POST['paymentMode']) ? $_POST['paymentMode'] : null;

    if (isset($_SESSION['discountedPrice'])) {
        $totalAmount = $_SESSION['discountedPrice'];
    } else {
        $totalAmount = $totalPurchaseValue;
    }

    $saveOrderQuery = "INSERT INTO orders (customer_id, order_date, total_amount, order_quantity)
  VALUES (?, CURRENT_TIMESTAMP, ?, ?)";


    $stmtSaveOrder = mysqli_prepare($con, $saveOrderQuery);

    echo " <script>console.log('$saveOrderQuery')</script>";

    if ($stmtSaveOrder) {
        mysqli_stmt_bind_param($stmtSaveOrder, "idd", $UserID, $totalAmount, $orderQuantity);

        $orderQuantity = 0;

        mysqli_stmt_execute($stmtSaveOrder);

        $orderId = mysqli_insert_id($con);

        mysqli_data_seek($result, 0);

        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row['ItemID'];
            $orderQuantity += $row['Quantity'];

            $updateOrderQuery = "UPDATE orders SET product_id = CONCAT(product_id, ',', ?) WHERE order_id = ?";
            $stmtUpdate = mysqli_prepare($con, $updateOrderQuery);

            if ($stmtUpdate) {
                mysqli_stmt_bind_param($stmtUpdate, "si", $productId, $orderId);
                mysqli_stmt_execute($stmtUpdate);
                mysqli_stmt_close($stmtUpdate);
            } else {
                echo "Error updating order with product IDs: " . mysqli_error($con);
            }
        }

        mysqli_stmt_close($stmtSaveOrder);
    } else {
        echo "Error preparing order query: " . mysqli_error($con);
    }

    $savePaymentQuery = "INSERT INTO payment (order_id, customer_id, payment_mode, amount_paid) 
 VALUES (?, ?, ?, ?)";

    $stmtSavePayment = mysqli_prepare($con, $savePaymentQuery);

    if ($stmtSavePayment) {
        mysqli_stmt_bind_param($stmtSavePayment, "iisd", $orderId, $UserID, $paymentMode, $totalAmount);

        $resultSavePayment = mysqli_stmt_execute($stmtSavePayment);

        if ($resultSavePayment) {
            echo "Payment details saved successfully.";
        } else {
            echo "Error saving payment details: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmtSavePayment);
    } else {
        echo "Error preparing payment details statement: " . mysqli_error($con);
    }

    mysqli_data_seek($result, 0);

    $productIDs = array();
    $quantities = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['ItemID'];
        $Quantity = $row['Quantity'];

        $updateItemsQuery = "UPDATE items SET Quantity = Quantity - ?, Solds = Solds + ? WHERE ItemID = ?";
        $stmtUpdateItems = mysqli_prepare($con, $updateItemsQuery);

        if ($stmtUpdateItems) {
            mysqli_stmt_bind_param($stmtUpdateItems, "iii", $Quantity, $Quantity, $productId);
            mysqli_stmt_execute($stmtUpdateItems);
            mysqli_stmt_close($stmtUpdateItems);

            $productIDs[] = $productId;
            $quantities[] = $Quantity;
        } else {
            echo "Error updating quantity and sold count: " . mysqli_error($con);
        }
    }

    $productIDsString = implode(',', $productIDs);
    $quantitiesString = implode(',', $quantities);

    $updateOrderQuery = "UPDATE orders SET product_id = ?, order_quantity = ? WHERE order_id = ?";
    $stmtUpdateOrder = mysqli_prepare($con, $updateOrderQuery);

    if ($stmtUpdateOrder) {
        mysqli_stmt_bind_param($stmtUpdateOrder, "ssi", $productIDsString, $quantitiesString, $orderId);
        mysqli_stmt_execute($stmtUpdateOrder);
        mysqli_stmt_close($stmtUpdateOrder);
    } else {
        echo "Error updating order with product IDs and quantities: " . mysqli_error($con);
    }

    $productIDsString = implode(',', $productIDs);
    $updateOrderQuery = "UPDATE orders SET product_id = ? WHERE order_id = ?";
    $stmtUpdateOrder = mysqli_prepare($con, $updateOrderQuery);

    if ($stmtUpdateOrder) {
        mysqli_stmt_bind_param($stmtUpdateOrder, "si", $productIDsString, $orderId);
        mysqli_stmt_execute($stmtUpdateOrder);
        mysqli_stmt_close($stmtUpdateOrder);
    } else {
        echo "Error updating order with product IDs: " . mysqli_error($con);
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
    <?php include("header.php");
    include("popups.php"); ?>
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
                <div class="payment-button"> <button class="buybtn" type="submit">Submit Payment</button> </div>
            </form>
        </div>
    </div>
    <?php
    include("footer.php");
    ?>
</body>

</html>