
<?php

if (isset($_GET['ItemID'])) {

    $delete_id = $_GET['ItemID'];

    $delete_pro = "delete from Items where ItemID='$delete_id'";

    $run_delete = mysqli_query($con, $delete_pro);

    if ($run_delete) {

        echo "<script>alert('One Product Has been deleted')</script>";

        echo "<script>window.open('admin.php?view_products','_self')</script>";
    }
}

?>