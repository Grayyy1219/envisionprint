<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CategoryID = isset($_POST["CategoryID"]) ? $_POST["CategoryID"] : '';
    $oldCategory = isset($_POST["oldcategory"]) ? $_POST["oldcategory"] : '';
    $title = isset($_POST["title"]) ? $_POST["title"] : '';

    $location = '';

    if (isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
        $name = $_FILES['img']['name'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $location = "upload/$name";
        if (!move_uploaded_file($tmp_name, $location)) {
            echo "Error uploading file.";
            exit;
        }
    } elseif (isset($_FILES['img']) && $_FILES['img']['size'] == 0) {
    }

    $sql = "UPDATE category SET Category = ?";

    if (!empty($location)) {
        $sql .= ", img = ?";
    }
    $sql .= " WHERE CategoryID = ?";

    $stmt = $con->prepare($sql);

    if (!empty($location)) {
        $stmt->bind_param("ssi", $title, $location, $CategoryID);
    } else {
        $stmt->bind_param("si", $title, $CategoryID);
    }


    if ($stmt->errno) {
        echo "Error updating items: " . $stmt->error;
    } else {
        echo "<script>alert('Category and associated items updated successfully!');</script>";
        echo "<script>window.location.href = 'editgenre.php';</script>";
    }

    $stmt->execute();


    if ($stmt->errno) {
        echo "Error updating record: " . $stmt->error;
    } else {
        $sql = "UPDATE items SET Category = ? WHERE Category = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $title, $oldCategory);
        $stmt->execute();

        echo "<script>alert('Category updated successfully!');</script>";
        echo "<script>window.location.href = 'editgenre.php';</script>";
    }

    $stmt->close();
}
