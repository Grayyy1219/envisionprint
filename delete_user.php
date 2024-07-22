<?php

if (isset($_GET['UserID'])) {

    $delete_id = $_GET['UserID'];

    $delete_pro = "delete from users where UserID='$delete_id'";

    $run_delete = mysqli_query($con, $delete_pro);

    if ($run_delete) {

        echo "<script>alert('User Has been deleted')</script>";

        echo "<script>window.open('admin.php?view_user','_self')</script>";
    }
}
