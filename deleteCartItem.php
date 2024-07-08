<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Deleted successfully</title>
    <?php
    include("connect.php");
    include("query.php");
    ?>
    <link rel="stylesheet" href="css/global.css">
    <style>
        .popupd {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .done {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            color: #007BFF;
            cursor: pointer;
            margin-top: 20px;
        }

        .back-button:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST['deleteSelected'])) {
        $customerId = $UserID;

        if (!empty($_POST['selectedItems'])) {
            $selectedItems = implode(',', $_POST['selectedItems']);
            $deleteItemsQuery = "DELETE FROM cart WHERE cart_id IN ($selectedItems) AND customer_id = $customerId";
            $result = mysqli_query($con, $deleteItemsQuery);

            if (!$result) {
                echo "Error deleting items: " . mysqli_error($con);
            } else { ?>
                <div class="popupd">
                    <div class="done">
                        <img src="css/img/check.png" alt="Success" style="width: 200px; height: 200px;">
                        <p>Deleted successfully</p>
                        <p class="back-button" onclick="backref()">Go Back</p>
                    </div>
                </div>
    <?php }
        }
    }
    ?>
</body>

</html>