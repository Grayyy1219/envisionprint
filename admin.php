<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel</title>
    <?php include("connect.php");
    include("query.php"); ?>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="icon" href="Image/logo.ico">

</head>

<body>

    <header>
        <nav class="toppanel">
            <img src="css/img/logo.png" alt="">
            EnVision Print
        </nav>
        <div class="sidepanel">
            <a href="admin.php?dashboard">Dashboard</a>

            <a href="admin.php?edit_page">Customer Page</a>


            <a href="#" class="toggle" data-target="#products">Products</a>
            <div id="products" class="collapse nested-menu">
                <a href="admin.php?insert_products">Insert Product</a>
                <a href="admin.php?view_products">View Products</a>
            </div>

            <a href="admin.php?deals">Deals</a>

            <a href="admin.php?view_orders">Orders</a>

            <a href="#" class="toggle" data-target="#Categories">Categories</a>
            <div id="Categories" class="collapse nested-menu">
                <a href="admin.php?insert_category">Insert Category</a>
                <a href="admin.php?view_category">View Categories</a>
            </div>

            <a href="#" class="toggle" data-target="#customers">View Customers</a>
            <div id="customers" class="collapse nested-menu">
                <a href="admin.php?view_user">Customer List</a>
            </div>

            <a href="admin.php?return">Returns</a>

            <!-- <a href="#" class="toggle" data-target="#reports">Reports</a>
            <div id="reports" class="collapse nested-menu">
                <a href="admin.php?reports">View Reports</a>
            </div> -->

            <a href="#" class="toggle" data-target="#Info">Admin Info</a>
            <div id="Info" class="collapse nested-menu">
                <a href="admin.php?aedituser">Change Basic info</a>
                <a href="admin.php?aeditpass">Change password</a>
            </div>
            <a href="logout.php">Log Out</a>
        </div>
    </header>
    <div class="dom">
        <?php
        if (isset($_GET['dashboard'])) {
            include("dashboard.php");
        }
        if (isset($_GET['edit_page'])) {
            include("admineditpage.php");
        }
        if (isset($_GET['view_products'])) {
            include("view_products.php");
        }
        if (isset($_GET['delete_product'])) {
            include("delete_product.php");
        }
        if (isset($_GET['edit_product'])) {
            include("edit_product.php");
        }
        if (isset($_GET['insert_products'])) {
            include("insert_products.php");
        }
        if (isset($_GET['view_category'])) {
            include("view_category.php");
        }
        if (isset($_GET['edit_category'])) {
            include("edit_category.php");
        }
        if (isset($_GET['insert_category'])) {
            include("Insert_category.php");
        }
        if (isset($_GET['view_user'])) {
            include("blockuser.php");
        }
        if (isset($_GET['edit_user'])) {
            include("edit_user.php");
        }
        if (isset($_GET['delete_user'])) {
            include("delete_user.php");
        }
        if (isset($_GET['view_orders'])) {
            include("view_orders.php");
        }
        if (isset($_GET['return'])) {
            include("return.php");
        }
        if (isset($_GET['deals'])) {
            include("deals.php");
        }
        if (isset($_GET['payment_history'])) {
            include("paymenthistory.php");
        }
        if (isset($_GET['aedituser'])) {
            include("aedituser.php");
        }
        if (isset($_GET['aeditpass'])) {
            include("aeditpass.php");
        }
        if (isset($_GET['reports'])) {
            include("printreport.php");
        }
        ?>

    </div>
    <script>
        document.querySelectorAll('.toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(event) {
                event.preventDefault();
                var target = document.querySelector(this.getAttribute('data-target'));
                if (target.classList.contains('show')) {
                    target.classList.remove('show');
                } else {
                    target.classList.add('show');
                }
            });
        });
    </script>

</body>

</html>