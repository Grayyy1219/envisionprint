<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $category = $_POST["category"];
    $description = mysqli_real_escape_string($con, $_POST["description"]);
    $price = isset($_POST["price"]) ? $_POST["price"] : null;
    $quantity = $_POST["quantity"];

    if (isset($_FILES['ItemImg']) && $_FILES['ItemImg']['size'] > 0) {
        $name = $_FILES['ItemImg']['name'];
        $tmp_name = $_FILES['ItemImg']['tmp_name'];
        $location = "upload/item/$name";
        if (move_uploaded_file($tmp_name, $location)) {
            $ItemImg = $location;
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        $ItemImg = "default_image_path.jpg";
    }

    $query = "INSERT INTO items (ItemName, Description, Category, ItemImg, Price, Quantity) 
              VALUES ('$title', '$description', '$category', '$ItemImg', '$price', '$quantity')";

    if (mysqli_query($con, $query)) {
        echo '<script>alert("Product added successfully!");</script>';
        echo "<script>window.location.href = 'admin.php?dashboard';</script>";
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}
