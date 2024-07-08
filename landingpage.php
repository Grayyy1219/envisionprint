<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnVision Print.</title>
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
            <?php include("categories.php"); ?>
        </div>
        </div>
    </section>
    <?php include("footer.php"); ?>
    <script src="config/slideshow.js"></script>
</body>

</html>