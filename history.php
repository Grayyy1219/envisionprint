<?php
include("connect.php");
include("query.php");

$selectQuery = "SELECT items.*, orders.order_date, orders.order_quantity, orders.status
                FROM items
                JOIN orders ON items.ItemID  = orders.product_id
                WHERE orders.customer_id = '$UserID'  ORDER BY `orders`.`order_date` DESC";
$result = mysqli_query($con, $selectQuery);
?>

<html>

<head>
    <title>Purchase history</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/cart.css">
    <style>

    </style>
</head>

<body>
    <?php include("header.php");
    include("popups.php");

    $selected_category = isset($_GET['genre']) ? $_GET['genre'] : '';

    $items_per_page = 5;

    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($current_page - 1) * $items_per_page;

    $where_clause = '';
    if ($selected_category) {
        $where_clause = "WHERE genre = '" . mysqli_real_escape_string($con, $selected_category) . "'";
    }

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
    SELECT items.*, orders.order_date, orders.order_quantity, orders.status
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
                            <th>#</th>
                            <th style="text-align: start;">Product</th>
                            <th>Price</th>
                            <th style="width: 100px;">Order Date</th>
                            <th>Status</th>
                        </tr>
                        <tbody>
                            <?php
                            $i = $offset;
                            while ($row_pro = mysqli_fetch_array($run_pro)) {
                                $pro_id = $row_pro['ItemID'];
                                $pro_title = $row_pro['ItemName'];
                                $pro_image = $row_pro['ItemImg'];
                                $pro_price = $row_pro['Price'];
                                $order_date = date('F j, Y', strtotime($row_pro['order_date']));
                                $i++;
                            ?>
                                <tr class="cart-item" style="height: 75px;">
                                    <td><?php echo $i; ?></td>
                                    <td style="width: 50%;">
                                        <div class="product">
                                            <img src="<?php echo $pro_image; ?>" width="60" height="60" alt="Product Image">
                                            <div style="text-align: start;font-size: 12px;"> <?= $pro_title; ?></div>
                                        </div>
                                    </td>
                                    <td>₱ <?php echo $pro_price; ?></td>
                                    <td><?php echo $order_date; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination-container_category" class="pageno">
                    <?php if ($current_page > 1) : ?>
                        <div><a href="http://localhost/envisionprint/history.php?genre=<?php echo $selected_category; ?>&page=<?php echo $current_page - 1; ?>">&laquo; Previous</a></div>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                        <div <?php if ($page == $current_page) echo 'class="active"'; ?>>
                            <a href="http://localhost/envisionprint/history.php?genre=<?php echo $selected_category; ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>
                        </div>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <div><a href="http://localhost/envisionprint/history.php?genre=<?php echo $selected_category; ?>&page=<?php echo $current_page + 1; ?>">Next &raquo;</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </form>
</body>

</html>