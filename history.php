<!DOCTYPE html>
<html lang="en">
<?php
include("connect.php");
include("query.php");
?>

<head>
    <title>Purchase history</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/history.css">
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            width: 20px;
            height: 20px;
            background: url('star-empty.png') no-repeat;
            background-size: contain;
        }


        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            background: url('star-filled.png') no-repeat;
            background-size: contain;
        }
    </style>
</head>

<body>
    <?php include("header.php");

    $items_per_page = 10;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $items_per_page;
    $where_clause = '';

    $total_items_query = "
    SELECT COUNT(*) AS count 
    FROM items 
    JOIN orders ON FIND_IN_SET(items.ItemID, orders.product_id) 
    WHERE orders.customer_id = '$UserID' $where_clause";
    $total_items_result = mysqli_query($con, $total_items_query);
    $total_items_row = mysqli_fetch_assoc($total_items_result);
    $total_items = $total_items_row['count'];

    $total_pages = ceil($total_items / $items_per_page);

    $get_pro = "
    SELECT items.*, orders.order_id, orders.order_date, orders.order_quantity, orders.rating as order_rating, orders.status
    FROM items
    JOIN orders ON FIND_IN_SET(items.ItemID, orders.product_id)
    WHERE orders.customer_id = '$UserID'
    ORDER BY orders.order_date DESC
    LIMIT $offset, $items_per_page";

    $run_pro = mysqli_query($con, $get_pro);

    $totalRecords = mysqli_num_rows(mysqli_query($con, "SELECT * FROM orders WHERE customer_id = '$UserID' "));

    ?>
    <form method="post" action="" id="cartForm" enctype="multipart/form-data">
        <section class="center">
            <div class="Itemcart">
                <h1>Purchase history</h1>
                <div class="cart-container">
                    <p class="cart-tip"> <?= $totalRecords ?> total Purchase/s.</p>
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
                            $i = $offset;
                            $last_id = null;
                            $last_date = null;
                            while ($row_pro = mysqli_fetch_array($run_pro)) {
                                $current_id = $row_pro['order_id'];
                                $pro_title = $row_pro['ItemName'];
                                $pro_image = $row_pro['ItemImg'];
                                $current_date = $row_pro['order_date'];
                                $rating = $row_pro['order_rating'];
                                $status = $row_pro['status'];
                                $getorderinfosql = "SELECT amount_paid, payment_mode FROM `payment` where order_id = $current_id";
                                $getorderinforow = mysqli_query($con, $getorderinfosql);
                                $orderinforow = mysqli_fetch_assoc($getorderinforow);

                                if ($current_date != $last_date) {
                                    $order_date = date('F j, Y', strtotime($current_date));
                                    $last_date = $current_date;
                                    $order_id = $current_id;
                                    $price = "₱ " . $orderinforow['amount_paid'];
                                    $payment_mode = $orderinforow['payment_mode'];
                                    if ($rating > 0) {
                                        $rating_html = "<div class='star-rating'>";
                                        for ($i = 5; $i >= 1; $i--) {
                                            if ($rating <= $i) {
                                                $rating_html .= "<input type='radio' name='rating-$order_id' id='rating-$order_id-$i' value='$i' checked><label for='rating-$order_id-$i'></label>";
                                            } else {
                                                $rating_html .= "<input type='radio' name='rating-$order_id' id='rating-$order_id-$i' value='$i'><label for='rating-$order_id-$i'></label> ";
                                            }
                                        }
                                        $rating_html .= "</div>";
                                    } else {
                                        $rating_html = "<div class='ratingtd'> <div class='star-rating'>
                                            <input type='radio' name='rating-$order_id' id='rating-$order_id-5' value='5'><label for='rating-$order_id-5'></label>
                                            <input type='radio' name='rating-$order_id' id='rating-$order_id-4' value='4'><label for='rating-$order_id-4'></label>
                                            <input type='radio' name='rating-$order_id' id='rating-$order_id-3' value='3'><label for='rating-$order_id-3'></label>
                                            <input type='radio' name='rating-$order_id' id='rating-$order_id-2' value='2'><label for='rating-$order_id-2'></label>
                                            <input type='radio' name='rating-$order_id' id='rating-$order_id-1' value='1'><label for='rating-$order_id-1'></label>
                                        </div>
                                        <input type='submit' class='ratebtn' formaction='save_rating.php' value='Save Rating'></div>";
                                    }
                                    $style = "class='tdb'";
                                    if ($status == "0") {
                                        $returnbtn = "<button class='buybtn' onclick='recivedorder($order_id)'>Received</button>";
                                    } else if ($status == "1") {
                                        $returnbtn = "<div><p>Order received.<br><img src='star.png' width='20px'><br></p><button class='buybtn' onclick='returnorder($order_id)'>Return</button></div>";
                                    } else if ($status == "2") {
                                        $returnbtn = "<p>Pending Return</p>";
                                    } else if ($status == "3") {
                                        $returnbtn = "<p>Return Approved</p>";
                                    }
                                } else {
                                    $order_date = " ";
                                    $order_id = " ";
                                    $price = " ";
                                    $payment_mode = " ";
                                    $style = " ";
                                    $returnbtn = " ";
                                    $rating_html = " ";
                                }
                            ?>
                                <tr class="cart-item" style="height: 55px">
                                    <td <?= $style ?> style="font-size: 12px;"><?php echo $order_id; ?></td>
                                    <td <?= $style ?> style="width: 50%;">
                                        <div class="product">
                                            <img src="<?php echo $pro_image; ?>" width="30" height="30" alt="Product Image">
                                            <div style="text-align: start;font-size: 12px;"> <?= $pro_title; ?></div>
                                        </div>
                                    </td>
                                    <td <?= $style ?> style="font-size: 12px;"><?= $price . "<br>" . $payment_mode ?></td>
                                    <td <?= $style ?>> <?= $order_date ?></td>
                                    <td <?= $style ?> class="ratingtd"><?= $rating_html ?></td>
                                    <td <?= $style ?>><?= $returnbtn ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination-container_category" class="pageno">
                    <?php if ($current_page > 1) : ?>
                        <div><a href="http://localhost/envisionprint/history.php?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a></div>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                        <div <?php if ($page == $current_page) echo 'class="active"'; ?>>
                            <a href="http://localhost/envisionprint/history.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                        </div>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <div><a href="http://localhost/envisionprint/history.php?page=<?php echo $current_page + 1; ?>">Next &raquo;</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <input type="submit" value="Save Ratings">
    </form>
    <script>
        function recivedorder(order_id) {
            if (confirm("Are you sure you have received the order?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_order_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        console.log("XHR status: " + xhr.status);
                        console.log("XHR response: " + xhr.responseText);
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

        function returnorder(order_id) {
            if (confirm("Are you sure you want to return the order?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_order_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        console.log("XHR status: " + xhr.status);
                        console.log("XHR response: " + xhr.responseText);
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            location.reload();
                        } else {
                            alert("Error updating order status.");
                        }
                    }
                };
                xhr.send("action=return&order_id=" + order_id);
            }
        }
    </script>
</body>

</html>