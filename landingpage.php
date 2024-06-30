<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta http-equiv="refresh" content="1"> -->
    <title>EnVision Print</title>
    <?php
    include("connect.php");
    include("query.php"); ?>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/slideshow.css">
    <link rel="stylesheet" href="css/landingpage.css">
</head>

<body>
    <?php
    include("header.php");
    if ($username != 0 && $block == 1) {
        echo '<script>alert("Your account has been blocked. \n Please contact your administrator for assistance.");</script>';
        echo "<script>window.location.href = 'logout.php';</script>";
    }
    ?>
    <section>
        <div class="" id="w1">
            <div class=" slideshow-container">
                <button class="prev-button">&#10094;</button>
                <div class="slides-container">
                    <?php
                    $query = mysqli_query($con, "select * from slideshow");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $location = $row["imagelocation"];
                        echo "<div class='slide'><img class='slideimg' src='$location'></div>";
                    }
                    ?>
                </div>
                <button class="next-button">&#10095;</button>
                <div class="dot-container"></div>
            </div>
        </div>
    </section>
    <section>
        <div class="" id="w2">
            <?php include("category.php"); ?>
        </div>
        </div>
    </section>
    <footer>
        <div class="companyname">
            <h1>Tiktok.com/@envisionprint1221</h1>
        </div>
        <div class="flinks">
            <a href="">
                <p>Home</p>
            </a>
            <a href="">
                <p>About</p>
            </a>
            <a href="">
                <p>Contacts</p>
            </a>
            <a href="logout.php">
                <p>Logout</p>
            </a>
        </div>
        <ul class="fsocials">
            <li class="ftco-animate"><a href="https://www.facebook.com" target="_blank"><img src="css/img/facebook.png" alt="fb" width="10px"></a></li>
            <li class="ftco-animate"><a href="https://www.instagram.com/" target="_blank"><img src="css/img/instagram.png" alt="insta" width="10px"></a></li>
            <li class="ftco-animate"><a href="https://www.tiktok.com/@envisionprint1221" target="_blank"><img src="css/img/tik-tok.png" alt="tiktok" width="10px"></a></li>
        </ul>
        <div>
            <p>Copyright ©2024 All rights reserved | <b>EnVision Print</b></p>
        </div>
    </footer>






    <script src="config/slideshow.js"></script>
</body>

</html>