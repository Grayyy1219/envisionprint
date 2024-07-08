<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add to Cart</title>
    <?php
    include("connect.php");
    include("query.php");
    ?>
    <link rel="stylesheet" href="css/global.css">
    <style>
        .popupd {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .done {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            color: #007BFF;
            cursor: pointer;
            margin-top: 20px;
        }

        .back-button:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    include("header.php");
    include("popups.php");

    $productName = mysqli_real_escape_string($con, $_POST['Title']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);

    $productResult = mysqli_query($con, "SELECT * FROM items WHERE ItemName = '$productName' LIMIT 1");

    if (!$productResult) {
        echo "Error retrieving product details: " . mysqli_error($con);
        exit();
    }

    $productRow = mysqli_fetch_assoc($productResult);
    $product_id = $productRow['ItemID'];
    $totalQuantity = $productRow['Quantity'];

    $checkCartResult = mysqli_query($con, "SELECT * FROM cart WHERE customer_id = $UserID AND ItemID = $product_id");
    $quantityInCart = mysqli_num_rows($checkCartResult) > 0 ? mysqli_fetch_assoc($checkCartResult)['quantity'] : 0;
    $availableQuantity = $totalQuantity - $quantityInCart;

    if ($quantity > $availableQuantity) {
        $quantity = $availableQuantity; ?>
        <div class="popupd">
            <div class="done">
                <img src='css/img/cancel.png' style='width: 100px; height: 100px;'>
                <p style='font-size: 14px; font-weight: bold; margin-top: 10px;'>Apologies, we only have <?= $availableQuantity ?> units available in stock.<br>Perhaps some are already in your cart.</p>
                <p class="back-button" onclick='backref()'>Go Back</p>
            </div>
        </div>
    <?php
        include("footer.php");
        exit();
    }

    $cartQuery = $quantityInCart > 0
        ? "UPDATE cart SET quantity = quantity + $quantity WHERE customer_id = $UserID AND ItemID = $product_id"
        : "INSERT INTO cart (customer_id, ItemID, quantity) VALUES ($UserID, $product_id, $quantity)";

    if (mysqli_query($con, $cartQuery)) {
    ?>
        <div class="popupd">
            <div class="done">
                <img src="css/img/check.png" alt="Success Image" style="width: 100px; height: 100px;">
                <p>Item successfully added to your cart!</p>
                <p class="back-button" onclick='backref()'>Go Back</p>
            </div>
        </div>
    <?php
    } else {
        echo "Error updating the cart: " . mysqli_error($con);
    }
    ?>

    <?php include("footer.php"); ?>
</body>

</html>