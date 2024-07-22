<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["CategoryID"])) {
    $CategoryIDs = explode(',', $_POST["CategoryID"]);

    foreach ($CategoryIDs as $CategoryID) {
        $CategoryID = mysqli_real_escape_string($con, $CategoryID);

        $query = "DELETE FROM category WHERE CategoryID = '$CategoryID'";
        $result = mysqli_query($con, $query);
    }

    if ($result) {
        echo "genre deleted successfully";
    } else {
        echo "Error deleting genre: " . mysqli_error($con);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid request";
}

mysqli_close($con);
