<!DOCTYPE html>
<html lang="en">
<?php
include("connect.php");
include("query.php");
?>

<head>
    <title>Purchase History</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/history.css">
    <style>


    </style>
</head>

<body>
    <?php include("header.php");

    $items_per_page = 4;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $items_per_page;
    $where_clause = '';

    $total_items_query = "
    SELECT COUNT(DISTINCT orders.order_id) AS count 
    FROM items 
    JOIN orders ON FIND_IN_SET(items.ItemID, orders.product_id) 
    WHERE orders.customer_id = '$UserID' $where_clause";
    $total_items_result = mysqli_query($con, $total_items_query);
    $total_items_row = mysqli_fetch_assoc($total_items_result);
    $total_items = $total_items_row['count'];

    $total_pages = ceil($total_items / $items_per_page);

    $get_pro = "
    SELECT orders.order_id, orders.order_date, orders.order_quantity, orders.rating as order_rating, orders.status,
           GROUP_CONCAT(items.ItemName SEPARATOR ', ') AS item_names,
           GROUP_CONCAT(items.ItemImg SEPARATOR ', ') AS item_images,
           SUM(payment.amount_paid) AS amount_paid,
           payment.payment_mode
    FROM items
    JOIN orders ON FIND_IN_SET(items.ItemID, orders.product_id)
    JOIN payment ON orders.order_id = payment.order_id
    WHERE orders.customer_id = '$UserID'
    GROUP BY orders.order_id
    ORDER BY orders.order_date DESC
    LIMIT $offset, $items_per_page";

    $run_pro = mysqli_query($con, $get_pro);

    $totalRecords = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT order_id FROM orders WHERE customer_id = '$UserID' "));
    ?>
    <form method="post" action="" id="cartForm" enctype="multipart/form-data">
        <section class="center">
            <div class="Itemcart">
                <h1>Purchase History</h1>
                <div class="cart-container">
                    <p class="cart-tip"><?= $totalRecords ?> total Purchase/s.</p>
                    <table class="itemtable">
                        <tr>
                            <th>Ref #</th>
                            <th style="text-align: start;">Product</th>
                            <th>Details</th>
                            <th style="width: 100px;">Order Date</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                            <?php
                            while ($row_pro = mysqli_fetch_array($run_pro)) {
                                $current_id = $row_pro['order_id'];
                                $item_names = $row_pro['item_names'];
                                $item_images = explode(', ', $row_pro['item_images']);
                                $current_date = $row_pro['order_date'];
                                $rating = $row_pro['order_rating'];
                                $status = $row_pro['status'];
                                $amount_paid = $row_pro['amount_paid'];
                                $payment_mode = $row_pro['payment_mode'];

                                $order_date = date('F j, Y', strtotime($current_date));
                                $price = "₱ " . $amount_paid;

                                // Define statuses
                                $statuses = [
                                    "-1" => "Processing",
                                    "0" => "Placed",
                                    "1" => "Received",
                                    "2" => "Pending Return",
                                    "3" => "Return Approved",
                                    "4" => "Request Rejected"
                                ];

                                // Determine the current status
                                $status_step_html = '';
                                foreach ($statuses as $key => $label) {
                                    if ($key < $status) {
                                        $status_step_html .= "<div class='status-step status-completed'>{$label}</div>";
                                    } elseif ($key == $status) {
                                    }
                                }

                                // Add actions based on status
                                if ($status == "0") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        $status_step_html
                                        <p class='status-step status-current'>To received. </p>
                                        <div class='status-text'>
                                            <button class='ratebtn' onclick='recivedorder($current_id)'>Mark as Received</button>
                                        </div>
                                    </div>";
                                } elseif ($status == "1") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        $status_step_html
                                        <p class='status-step status-completed'>Order received. </p>
                                        <div class='status-text'>
                                            <div class='ratebtn' style='padding:5px 10px;' onclick='returnOrder($current_id)'>Request Return?</div>
                                        </div>
                                    </div>";
                                } elseif ($status == "2") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        $status_step_html
                                        <div class='status-text status-current'>Pending Return</div>
                                    </div>";
                                } elseif ($status == "3") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        $status_step_html
                                        <div class='status-step status-completed'>Return Approved</div>
                                    </div>";
                                } elseif ($status == "4") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        <div class='status-text' style='color:red;'>Return Rejected</div>
                                    </div>";
                                } elseif ($status == "-1") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        <div class='status-text status-current'>Processing</div>
                                    </div>";
                                } elseif ($status == "-2") {
                                    $returnbtn = "
                                    <div class='status-container'>
                                        <div class='status-text' style='color:red;'>Order Canceled</div>
                                    </div>";
                                }

                                // Rating HTML
                                if ($rating > 0) {
                                    $rating_html = "<div class='star-rating'>";
                                    for ($i = 5; $i >= 1; $i--) {
                                        if ($rating <= $i) {
                                            $rating_html .= "<input type='radio' name='rating-$current_id' id='rating-$current_id-$i' value='$i' checked><label for='rating-$current_id-$i'></label>";
                                        } else {
                                            $rating_html .= "<input type='radio' name='rating-$current_id' id='rating-$current_id-$i' value='$i'><label for='rating-$current_id-$i'></label>";
                                        }
                                    }
                                    $rating_html .= "</div>";
                                } elseif ($status <= 0) {
                                    $rating_html = "";
                                } else {
                                    $rating_html = "<div class='ratingtd'> <div class='star-rating'>
                                        <input type='radio' name='rating-$current_id' id='rating-$current_id-5' value='5'><label for='rating-$current_id-5'></label>
                                        <input type='radio' name='rating-$current_id' id='rating-$current_id-4' value='4'><label for='rating-$current_id-4'></label>
                                        <input type='radio' name='rating-$current_id' id='rating-$current_id-3' value='3'><label for='rating-$current_id-3'></label>
                                        <input type='radio' name='rating-$current_id' id='rating-$current_id-2' value='2'><label for='rating-$current_id-2'></label>
                                        <input type='radio' name='rating-$current_id' id='rating-$current_id-1' value='1'><label for='rating-$current_id-1'></label>
                                        
                                    </div><input type='submit' class='ratebtn' formaction='save_rating.php' value='Save Rating'></div>";
                                }
                            ?>
                                <tr>
                                    <td class="tdb" style="font-size: 12px;"><?php echo $current_id; ?></td>
                                    <td class="tdb" style="width: 50%;">
                                        <div class="product">
                                            <?php
                                            $item_names_array = explode(', ', $item_names);
                                            $item_images_array = explode(', ', $row_pro['item_images']);

                                            // Ensure we have the same number of names and images
                                            $count = count($item_images_array);
                                            for ($i = 0; $i < $count; $i++) {
                                                $name = isset($item_names_array[$i]) ? $item_names_array[$i] : '';
                                                $image = isset($item_images_array[$i]) ? $item_images_array[$i] : '';
                                            ?>
                                                <div class="items">
                                                    <img src="<?php echo $image; ?>" width="30" height="30" alt="Product Image">
                                                    <span style="font-size: 12px;"><?= $name; ?></span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="tdb" style="font-size: 12px;"><?php echo $price . "<br>" . $payment_mode ?></td>
                                    <td class="tdb"><?= $order_date ?></td>
                                    <td class="tdb"><?= $rating_html ?></td>
                                    <td class="tdb staustd"><?= $returnbtn ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination-container_category" class="pageno">
                    <?php if ($current_page > 1) : ?>
                        <div><a href="history.php?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a></div>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                        <div <?php if ($page == $current_page) echo 'class="active"'; ?>>
                            <a href="history.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                        </div>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <div><a href="history.php?page=<?php echo $current_page + 1; ?>">Next &raquo;</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <input type="submit" value="Save Ratings">
    </form>
    <div id="returnModal" style="display:none;">
        <div style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);">
            <div style="background:#fff;padding:20px;border-radius:5px;width:300px;margin:100px auto;">
                <h3>Return Order</h3>
                <p>Please select the reason for returning the order:</p>
                <select id="returnReason">
                    <option value="Damaged item">Damaged item</option>
                    <option value="Received wrong item">Received wrong item</option>
                    <option value="Item not as described">Item not as described</option>
                    <option value="Changed mind">Changed mind</option>
                    <option value="Other">Other</option>
                </select>
                <br><br>
                <button onclick="submitReturnOrder()">Submit</button>
                <button onclick="closeReturnModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function recivedorder(order_id) {
            if (confirm("Are you sure you have received the order?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_order_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            location.reload();
                        } else {
                            alert("Error updating order status.");
                        }
                    }
                };
                xhr.send("action=received&order_id=" + order_id);
            }
        }

        let currentOrderId = null;

        function returnOrder(order_id) {
            document.getElementById('returnModal').style.display = 'block';
            currentOrderId = order_id;
        }

        function closeReturnModal() {
            document.getElementById('returnModal').style.display = 'none';
        }

        function submitReturnOrder() {
            const reason = document.getElementById('returnReason').value;
            if (reason) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_order_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            location.reload();
                        } else {
                            alert("Error updating order status.");
                        }
                    }
                };
                xhr.send("action=return&order_id=" + currentOrderId + "&reason=" + encodeURIComponent(reason));
            } else {
                alert("You must provide a reason for the return.");
            }
        }
    </script>

</body>

</html>