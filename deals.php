<link rel="stylesheet" href="css/deals.css">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_sale'])) {
    $product_id = $_POST['product_id'];
    $sale_price = $_POST['sale_price'];
    $con->query("UPDATE items SET onsale = 1, sale_price = $sale_price WHERE product_id = $product_id");
}

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

$imagesPerPage = 4;

$totalRecords = mysqli_num_rows(mysqli_query($con, "SELECT * FROM items WHERE onsale = '1' "));
$total_pages = ceil($totalRecords / $imagesPerPage);
$current_page = $_GET['page'];
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}
?>

<div class="label">
    <p>Flash Deals</p>
</div>
<form action="" id="myForm" method="post" enctype="multipart/form-data">
    <div class="hotdeals">
        <div class="dealscontainer">
            <?php
            $startIndex = ($current_page - 1) * $imagesPerPage;
            $stmt = $con->prepare("SELECT * FROM items WHERE onsale = '1' LIMIT ?, ?");
            $stmt->bind_param("ii",  $startIndex, $imagesPerPage);
            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $ItemID = $row["ItemID"];
                $ItemName = $row["ItemName"];
                $category = $row["Category"];
                $ItemImage = $row["ItemImg"];
                $Price = $row["Price"];
                $oldprice = $row["oldprice"];
                $Solds = $row["Solds"];
                $Rating = number_format($row["rating"], 2);
                $Quantity = $row["Quantity"];
                $Description = $row["Description"];
                $shortenedTitle = (strlen($ItemName) > 55) ? substr($ItemName, 0, 55) . '...' : $ItemName;
                $discount = 0;
                if ($oldprice > 0) {
                    $discount = (($oldprice - $Price) / $oldprice) * 100;
                }
            ?>
                <div class="itemdeal">
                    <div class="imgdeal">
                        <img src="<?= $ItemImage ?>" alt="" />
                    </div>
                    <div class="iteminfo">
                        <div>
                            <p><?= $ItemName ?></p>
                            <p class="stocks"><?= $Quantity ?> item/s left</p>
                            <p class="stocks">
                                <img src="css/img/star-filled.png" style="width: 12px; height: 12px" />(<?= $Rating ?>)
                            </p>
                        </div>
                        <div class="tocart">
                            <h3>₱<?= $Price ?></h3>
                            <div class="discountdiv">
                                <h5>₱<?= $oldprice ?></h5>
                                <p class="discount"><?= number_format($discount, 2) ?>% off</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="pagination">
            <ul class="pagination">
                <li><a href="?deals&page=<?php echo $current_page - 1; ?>">&laquo; Previous</a></li>
                <li><a href="?deals&page=<?php echo $current_page + 1; ?>">Next &raquo;</a></li>
            </ul>
        </div>

    </div>
</form>

<script>

</script>
<div class="form-container2">
    <div class="tab-buttons">
        <div class="tab-button active" onclick="showTab('existing')">Existing Item</div>
        <div class="tab-button" onclick="showTab('new')">New Deal</div>
    </div>
    <div class="editdisplay">
        <form method="POST" action="flash_deal_handler.php" enctype="multipart/form-data" id="deal-form">
            <div id="existing" class="tab active">
                <label for="item-select">Select Existing Item:</label>
                <select id="item-select" name="item_id" onchange="updatePreview()">
                    <option value="">--Select an item--</option>
                    <?php
                    // Fetch items from database
                    $items = $con->query("SELECT ItemID, ItemName, Price, ItemImg, Quantity, rating FROM items");
                    while ($item = $items->fetch_assoc()) {
                        echo "<option value='{$item['ItemID']}' data-details='" . htmlspecialchars(json_encode($item)) . "'>{$item['ItemName']}</option>";
                    }
                    ?>
                </select>
                <div class="help-text">Select an item from the list to apply a discount.</div>
            </div>

            <div id="new" class="tab">
                <label for="new-item-name">New Item Name:</label>
                <input type="text" id="new-item-name" name="new_item_name" onchange="updatePreview()">
                <div class="help-text">Enter the name of the new item.</div>

                <label for="new-item-price">Original Price:</label>
                <input type="number" id="new-item-price" name="new_item_price" onchange="updatePreview()">
                <div class="help-text">Enter the original price of the new item.</div>

                <label for="item-image">Item Image:</label>
                <input type="file" id="item-image" name="item_image" onchange="previewImage(event)">
                <div class="help-text">Select Item image of the new item.</div>

                <label for="quantity">Stocks:</label>
                <input type="number" id="quantity" name="quantity" onchange="updatePreview()">
                <div class="help-text">Enter Quantity for the item.</div>
            </div>

            <div>
                <label for="discounted-price">Discounted Price:</label>
                <input type="number" id="discounted-price" name="discounted_price" onchange="updatePreview()">
                <div class="help-text">Enter the discounted price for the item.</div>
            </div>
            <button type="submit">Submit</button>
        </form>

        <div class="display">
            <label for="">Preview</label>
            <div class="displayitemdeal">
                <div class="displayimgdeal">
                    <img id="preview-image" src="upload/category/sample.png" alt="">
                </div>
                <div class="displayiteminfo">
                    <div>
                        <p id="displaytitle">Sample Title</p>
                        <p class="displaystocks" id="displaystocks">0 item/s left</p>
                        <p class="displaystocks">
                            <img src="css/img/star-filled.png" style="width: 12px; height: 12px"><span id="displayrating">(0.00)</span>
                        </p>
                    </div>
                    <div class="displaytocart">
                        <h3 id="displayprice">₱0.00</h3>
                        <div class="displaydiscountdiv">
                            <h5 id="displayoldprice">₱0.00</h5>
                            <p class="displaydiscount" id="displaydiscount">0.00% off</p>
                        </div>
                    </div>
                    <div class="buy" onclick="submitForm('itempage.php?ItemID=1')">
                        <input type="submit" style="all:unset" class="div-29" value="Add to cart">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePreview() {
            const itemSelect = document.getElementById('item-select');
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            const itemDetails = selectedOption.getAttribute('data-details');

            if (itemDetails) {
                const item = JSON.parse(itemDetails);
                displayItemPreview(item);
            } else {
                const itemName = document.getElementById('new-item-name').value || 'Sample Title';
                const originalPrice = parseFloat(document.getElementById('new-item-price').value) || 0;
                const discountedPrice = parseFloat(document.getElementById('discounted-price').value) || 0;
                const quantity = parseInt(document.getElementById('quantity').value) || 0;

                const newItem = {
                    ItemName: itemName,
                    Price: originalPrice,
                    Quantity: quantity,
                    // Assuming other properties (like rating and image) are not dynamically changed
                };

                displayItemPreview(newItem);
            }
        }

        function displayItemPreview(item) {
            document.getElementById('displaytitle').textContent = item.ItemName;
            document.getElementById('displaystocks').textContent = `${item.Quantity} item/s left`;
            document.getElementById('preview-image').src = item.ItemImg || 'upload/category/sample.png'; // Update with actual logic if needed
            document.getElementById('displayrating').textContent = `(${parseFloat(item.rating).toFixed(2)})`;
            document.getElementById('displayoldprice').textContent = `₱${item.Price}`;

            const discountedPrice = parseFloat(document.getElementById('discounted-price').value) || item.Price;
            document.getElementById('displayprice').textContent = `₱${discountedPrice}`;

            if (item.Price > 0 && discountedPrice > 0) {
                const discount = ((item.Price - discountedPrice) / item.Price * 100).toFixed(2);
                document.getElementById('displaydiscount').textContent = `${discount}% off`;
            } else {
                document.getElementById('displaydiscount').textContent = '';
            }
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const previewImage = document.getElementById('preview-image');
                previewImage.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function submitForm(action) {
            document.getElementById('deal-form').action = action;
            document.getElementById('deal-form').submit();
        }
    </script>

</div>
<script>
    function submitForm(action) {
        document.getElementById("myForm").action = action;
        document.getElementById("myForm").submit();
    }

    function showTab(tabId) {
        var tabs = document.querySelectorAll('.tab');
        var buttons = document.querySelectorAll('.tab-button');

        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });

        buttons.forEach(function(button) {
            button.classList.remove('active');
        });

        document.getElementById(tabId).classList.add('active');
        document.querySelector('.tab-button[onclick="showTab(\'' + tabId + '\')"]').classList.add('active');
    }
</script>