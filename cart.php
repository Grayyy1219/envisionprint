<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'connect.php';
    include 'query.php'; ?>
    <title>User Cart</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/cart.css">
</head>

<?php
$getCartItemsQuery = "SELECT cart.cart_id, items.ItemID , items.ItemName, items.Quantity as maxQuantity, items.ItemImg, cart.Quantity, items.Price
                      FROM cart
                      INNER JOIN items ON cart.ItemID  = items.ItemID 
                      WHERE cart.customer_id = $UserID";
$result = mysqli_query($con, $getCartItemsQuery);
$totalCartValue = 0;
?>

<body>
    <?php include("header.php");
    include("popups.php"); ?>
    <form method="post" action="" id="cartForm" enctype="multipart/form-data">
        <section class="center">
            <div class="Itemcart">
                <h1>Your Shopping Cart</h1>
                <div class="cart-container">
                    <p class="cart-tip">Adjust the quantity to update your cart total automatically.</p>
                    <table class="itemtable">
                        <tr>
                            <th style="text-align: start;">Product</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)) {

                            $totalPrice = $row['Quantity'] * $row['Price'];
                            $totalCartValue += $totalPrice;
                            $maxQuantity = $row['maxQuantity'];
                        ?>
                            <tr class="cart-item" style="height: 75px;">
                                <td style="width: 50%;">
                                    <div class="product">
                                        <img src="<?= $row['ItemImg']; ?>" alt="Product Image" class="cart-item-image">
                                        <div style="text-align: start;font-size: 12px;"> <?= $row['ItemName']; ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?= $row['Price']; ?>
                                </td>
                                <td>
                                    <input class="number-input" type="number" name="quantity[]" value="<?= $row['Quantity']; ?>" min="1" max="<?= $row['maxQuantity'] ?>" data-price="<?= $row['Price']; ?>" data-cart-id="<?= $row['cart_id']; ?>" onchange="updateQuantity(this)">
                                    <p class="quantity-tip">Stocks: <?= $row['maxQuantity'] ?></p>
                                </td>
                                <td>
                                    <div class="total-price">
                                        <p class="sumtext"><?= $row['Quantity']; ?> x ₱<?= $row['Price'] ?></p>
                                        <p class="item-total-price">₱<?= number_format($totalPrice, 2) ?></p>
                                    </div>
                                </td>
                                <td class="select" style="width: 60px; text-align: center; padding-right: 0px;">
                                    <input type="checkbox" name="selectedItems[]" value="<?= $row['cart_id']; ?>" onchange="updateTotal(this)">
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </section>

        <div class="CartTotal">
            <div>
                <span id="totalCartValue">₱0.00</span>
                <p>Shipping & taxes calculated at checkout.</p>
            </div>
            <div>
                <button type="submit" class="deletebtn" name="deleteSelected" formaction="deleteCartItem.php" onclick="return confirmAction()">Delete Selected</button>
                <button type="submit" class="buybtn" name="buySelected" formaction="processCartAction.php">Check out</button>
            </div>
        </div>
    </form>
    <script>
        function confirmAction() {
            var checkboxes = document.getElementsByName('selectedItems[]');
            var checkedBoxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);
            if (checkedBoxes.length === 0) {
                alert("Please select an item to proceed to checkout.");
                return false;
            } else {
                return confirm("Would you like to confirm the deletion of selected items?");
            }
        }

        function updateTotal(checkbox) {
            var checkboxes = document.getElementsByName('selectedItems[]');
            var total = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    var totalPriceElement = checkboxes[i].closest('.cart-item').querySelector('.item-total-price');
                    var totalPriceText = totalPriceElement.textContent.trim();
                    var totalPrice = parseFloat(totalPriceText.replace(/[^\d.]/g, ''));
                    total += totalPrice;
                }
            }

            document.getElementById('totalCartValue').textContent = '₱' + total.toFixed(2);
        }

        function updateQuantity(input) {
            var quantity = input.value;
            var price = input.dataset.price;
            var cartId = input.dataset.cartId;
            var quantity = parseInt(input.value);
            var price = parseFloat(input.dataset.price);
            var totalPriceElement = input.closest('.cart-item').querySelector('.item-total-price');
            var newTotalPrice = quantity * price;

            totalPriceElement.textContent = '₱' + newTotalPrice.toFixed(2);

            var sumtextElement = input.closest('.cart-item').querySelector('.sumtext');
            sumtextElement.textContent = quantity + ' x ₱' + price.toFixed(2);

            updateCartTotal();
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "updateQuantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send("cart_id=" + cartId + "&quantity=" + quantity);
        }

        function updateCartTotal() {
            var checkboxes = document.getElementsByName('selectedItems[]');
            var total = 0;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var totalPriceElement = checkbox.closest('.cart-item').querySelector('.item-total-price');
                    var totalPriceText = totalPriceElement.textContent.trim();
                    var totalPrice = parseFloat(totalPriceText.replace(/[^\d.]/g, ''));
                    total += totalPrice;
                }
            });

            document.getElementById('totalCartValue').textContent = '₱' + total.toFixed(2);
        }
    </script>
    <?php include "footer.php"; ?>
</body>

</html>