<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ItemID'])) {
        $ItemID = mysqli_real_escape_string($con, $_POST['ItemID']);
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $Quantity = mysqli_real_escape_string($con, $_POST['quantity']);

        if (isset($_FILES['ItemImg']['name']) && !empty($_FILES['ItemImg']['name'])) {
            $targetDir = "upload/";
            $fileName = basename($_FILES["ItemImg"]["name"]);
            $targetFilePath = $targetDir . time() . '_' . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["ItemImg"]["tmp_name"], $targetFilePath)) {
                    $sql = "UPDATE items SET ItemName = '$title', Description = '$description', Category = '$category', Price = '$price', Quantity='$Quantity', ItemImg = '$targetFilePath' WHERE ItemID = $ItemID";
                    if (mysqli_query($con, $sql)) {
                        echo $targetFilePath;
                    } else {
                        echo "Error updating item information: " . mysqli_error($con);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
            }
        } else {
            $sql = "UPDATE items SET ItemName = '$title', Description = '$description', Category = '$category', Price = '$price', Quantity='$Quantity' WHERE ItemID = $ItemID";
            if (mysqli_query($con, $sql)) {
                $result = mysqli_query($con, "SELECT ItemImg FROM items WHERE ItemID = $ItemID");
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "Error updating item information: " . mysqli_error($con);
            }
        }
    } else {
        echo "Incomplete form data.";
    }
} else {
    echo "Invalid request method.";
}
