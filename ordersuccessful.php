<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Order Success</title>
    <?php include("connect.php");;
    include("query.php") ?>
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
    include("header.php");
    ?>
    <div class="popupd">
        <div class="done">
            <img src="css/img/check.png" alt="Success" style="width: 200px; height: 200px;">
            <p>Successfully Ordered!</p>
            <a href="Landingpage.php">
                <p class="back-button">Home</p>
            </a>
        </div>
    </div>

    <?php
    include("footer.html");
    ?>
</body>

</html>