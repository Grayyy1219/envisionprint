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
    SELECT items.*, orders.order_id, orders.order_date, orders.order_quantity, orders.status
    FROM items
    JOIN orders ON FIND_IN_SET(items.ItemID, orders.product_id)
    WHERE orders.customer_id = '$UserID'
    ORDER BY orders.order_date DESC
    LIMIT $offset, $items_per_page";

    $run_pro = mysqli_query($con, $get_pro);
    ?>
    <form method="post" action="" id="cartForm" enctype="multipart/form-data">
        <section class="center">
            <div class="Itemcart">
                <h1>Purchase history</h1>
                <div class="cart-container">
                    <p class="cart-tip">Adjust the quantity to update your cart total automatically.</p>
                    <table class="itemtable">
                        <tr>
                            <th>Ref #</th>
                            <th style="text-align: start;">Product</th>
                            <th>Details</th>
                            <th style="width: 100px;">Order Date</th>
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
                                    $style = "class='tdb'";
                                    if ($status == "0") {
                                        $returnbtn = "<button class='buybtn' onclick='recivedorder($order_id)'>Received</button>";
                                    } else if ($status == "1") {
                                        $returnbtn = "<div><p>Order received.</p><button class='buybtn' onclick='returnorder($order_id)'>Return</button></div>";
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