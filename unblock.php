<?php
include("connect.php");
include("query.php");

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];

    $sql = "UPDATE users SET block = 0 WHERE UserID IN ($userid)";

    // Execute the query
    if ($con->query($sql) === TRUE) {
        $successMessage = "User successfully unblocked.";
        echo "<script>
                alert('$successMessage');
                window.location.href = 'admin.php?view_user';
              </script>";
        exit();
    } else {
        // Display an alert if the query fails
        $errorMessage = "Error unblocking user: " . $con->error;
        echo "<script>
                alert('Error: $errorMessage');
                window.location.href = 'admin.php?view_user';
              </script>";
        exit();
    }
} else {
    // Display an alert if user ID is not set
    $noUserIdMessage = "User ID not provided.";
    echo "<script>
            alert('$noUserIdMessage');
            window.location.href = 'admin.php?view_user';
          </script>";
    exit();
}
