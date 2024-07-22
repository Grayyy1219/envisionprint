<?php

$categories_query = "SELECT DISTINCT Category FROM items";
$categories_result = mysqli_query($con, $categories_query);

$selected_category = isset($_GET['Category']) ? $_GET['Category'] : '';

$items_per_page = 8;

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($current_page - 1) * $items_per_page;

$where_clause = '';
if ($selected_category) {
    $where_clause = "WHERE Category = '" . mysqli_real_escape_string($con, $selected_category) . "'";
}

$total_items_query = "SELECT COUNT(*) AS count FROM items $where_clause";
$total_items_result = mysqli_query($con, $total_items_query);
$total_items_row = mysqli_fetch_assoc($total_items_result);
$total_items = $total_items_row['count'];

$total_pages = ceil($total_items / $items_per_page);

$get_pro = "SELECT * FROM items $where_clause LIMIT $offset, $items_per_page";
$run_pro = mysqli_query($con, $get_pro);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">View Products</h3>
            </div>
            <div class="panel-body">
                <form method="GET" action="admin.php">
                    <input type="hidden" name="view_products" value="1">
                    <div class="form-group">
                        <input type="hidden" name="view_products" value="1">
                        <div class="form-group">
                            <label for="category">Filter by Category:</label>
                            <select name="Category" id="category" class="form-control" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php while ($category_row = mysqli_fetch_assoc($categories_result)) : ?>
                                    <option value="<?php echo $category_row['Category']; ?>" <?php if ($selected_category == $category_row['Category']) echo 'selected'; ?>>
                                        <?php echo $category_row['Category']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Sold</th>
                                <th>Edit</th>
                                <th>Delete</th>
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
                                $Solds = $row_pro['Solds'];
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $pro_title; ?></td>
                                    <td><img src="<?php echo $pro_image; ?>" width="60" height="60"></td>
                                    <td>₱ <?php echo $pro_price; ?></td>
                                    <td><?php echo $Solds; ?></td>
                                    <td><a href="admin.php?edit_product&ItemID=<?php echo $pro_id; ?>" style="color: #337ab7; text-decoration: none;">Edit</a></td>
                                    <td><a href="admin.php?delete_product&ItemID=<?php echo $pro_id; ?>" style="color: #337ab7; text-decoration: none;" onclick="return confirmDelete();">Delete</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <ul class="pagination">
                        <?php if ($current_page > 1) : ?>
                            <li><a href="http://localhost/envisionprint/admin.php?view_products&Category=<?php echo $selected_category; ?>&page=<?php echo $current_page - 1; ?>">&laquo; Previous</a></li>
                        <?php endif; ?>

                        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                            <li <?php if ($page == $current_page) echo 'class="active"'; ?>>
                                <a href="http://localhost/envisionprint/admin.php?view_products&Category=<?php echo $selected_category; ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages) : ?>
                            <li><a href="http://localhost/envisionprint/admin.php?view_products&Category=<?php echo $selected_category; ?>&page=<?php echo $current_page + 1; ?>">Next &raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this product?');
    }
</script>