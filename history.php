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
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="icon" href="Image/logo.ico">
    <style>
        .penalty-form {
            margin-top: 10px;
        }

        .penalty-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .penalty-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .penalty-form p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #888;
        }

        .penalty-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .penalty-form button:hover {
            background-color: #45a049;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination ul {
            list-style-type: none;
            padding: 0;
        }

        .pagination li {
            display: inline;
            margin: 0 5px;
        }

        .pagination li a {
            text-decoration: none;
            color: #007bff;
        }

        .pagination li.active a {
            font-weight: bold;
            text-decoration: underline;
        }
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

<div class="row" style="width: 66%; margin: 50px auto;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #f5f5f5; border-color: #ddd;">
                <h3 class="panel-title" style="color: #333; font-weight: bold;">Purchase History</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th colspan="2">Product</th>
                                <th>Price</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
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
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $pro_title; ?></td>
                                    <td><img src="<?php echo $pro_image; ?>" width="60" height="60" alt="Product Image"></td>
                                    <td>₱ <?php echo $pro_price; ?></td>
                                    <td><?php echo $order_date; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <ul class="pagination">
                        <?php if ($current_page > 1) : ?>
                            <li><a href="http://localhost/envisionprint/history.php?genre=<?php echo $selected_category; ?>&page=<?php echo $current_page - 1; ?>">&laquo; Previous</a></li>
                        <?php endif; ?>

                        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                            <li <?php if ($page == $current_page) echo 'class="active"'; ?>>
                                <a href="http://localhost/envisionprint/history.php?genre=<?php echo $selected_category; ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages) : ?>
                            <li><a href="http://localhost/envisionprint/history.php?genre=<?php echo $selected_category; ?>&page=<?php echo $current_page + 1; ?>">Next &raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>