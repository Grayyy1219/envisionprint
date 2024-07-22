<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>EnVision Print</title>
    <?php
    include("connect.php");
    include("query.php");
    ?>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/landingpage.css">
    <link rel="stylesheet" href="css/page.css">

</head>

<body>

    <?php
    include("header.php");

    if (!isset($_GET['page'])) {
        $_GET['page'] = 1;
    }

    if (!isset($_GET['category'])) {
        exit("Category not set");
    }

    $category = $_GET['category'];
    $queryUser = mysqli_query($con, "SELECT * FROM category WHERE Category = '$category'");
    $rowUser2 = mysqli_fetch_assoc($queryUser);
    $imagesPerPage = 8;
    $currentPage = $_GET['page'];
    $totalRecords = mysqli_num_rows(mysqli_query($con, "SELECT * FROM items WHERE category = '$category' "));
    $totalPages = ceil($totalRecords / $imagesPerPage);
    ?>
    <div class="pagehead">
        <div class="categotytitle"><?= $category ?></div>
    </div>

    <form action="" id="myForm" method="post" enctype="multipart/form-data">
        <div id='shop'>
            <div class="search_count"><?= $totalRecords ?> item/s found for "<?= $category ?>"</div>
            <div class='shop'>

                <?php
                $startIndex = ($currentPage - 1) * $imagesPerPage;
                $stmt = $con->prepare("SELECT * FROM items WHERE category = ? LIMIT ?, ?");
                $stmt->bind_param("sii", $category, $startIndex, $imagesPerPage);
                $stmt->execute();

                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $ItemID = $row["ItemID"];
                    $ItemName = $row["ItemName"];
                    $category = $row["Category"];
                    $ItemImage = $row["ItemImg"];
                    $Price = $row["Price"];
                    $oldprice = $row["oldprice"];
                    $Solds = $row["Solds"];
                    $Rating = number_format($row["rating"], 2);
                    $Quantity = $row["Quantity"];
                    $Description = $row["Description"];
                    $shortenedTitle = (strlen($ItemName) > 55) ? substr($ItemName, 0, 55) . '...' : $ItemName;
                    $discount = 0;
                    if ($oldprice > 0) {
                        $discount = (($oldprice - $Price) / $oldprice) * 100;
                    }
                ?>
                    <div class='itemcard'>
                        <img src='<?= $ItemImage ?>'>
                        <div class="iteminfo">
                            <div>
                                <p><?= $shortenedTitle ?></p>
                                <p class='stocks'>Stocks <?= $Quantity ?></p>
                                <p class='stocks'><img src="css/img/star-filled.png" style="width: 15px; height: 15px;">(<?= $Rating ?>)</p>

                            </div>
                            <div class="tocart">
                                <h4>₱<?= $Price ?></h4>
                                <?php
                                if ($row['onsale'] == 1) { ?>
                                    <div class="discountdiv">
                                        <h5>₱<?= $oldprice ?></h5>
                                        <p class="discount"><?= number_format($discount, 2) ?>% off</p>
                                    </div>
                                <?php } ?>
                                <div class='buy' onclick="submitForm('itempage.php?ItemID=<?= $ItemID ?>')">
                                    <input type='submit' style='all:unset' class='div-29' value='Add to cart'>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
            </br></br>
            <div id='pagination-container_category' class='pageno'><b>Page: </b>
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $currentPage) ? 'selected-page' : '';
                    echo "<a class='pagination-link $activeClass' href='?category=$category&page=$i'>$i</a>";
                } ?>
            </div>
            <script>
                function submitForm(action) {
                    document.getElementById("myForm").action = action;
                    document.getElementById("myForm").submit();
                }
            </script>
    </form>
    </div>
    <section>
        <?php include("categories.php"); ?>
    </section>
    <?php include("footer.php"); ?>
</body>

</html>