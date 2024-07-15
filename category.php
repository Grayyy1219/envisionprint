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
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            width: 15px;
            height: 15px;
            background: url('star-empty.png') no-repeat;
            background-size: contain;
        }

        .star-rating input:checked~label {
            background: url('star-filled.png') no-repeat;
            background-size: contain;
        }
    </style>
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
        <div class="filter">
            <select name="" id="">
                <option value="">None</option>
                <option value="">Price Low to High</option>
                <option value="">Price High to Low</option>
            </select>
        </div>
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
                    $Solds = $row["Solds"];
                    $Rating = $row["rating"];
                    $Quantity = $row["Quantity"];
                    $Description = $row["Description"];
                    $shortenedTitle = (strlen($ItemName) > 55) ? substr($ItemName, 0, 55) . '...' : $ItemName;
                ?>
                    <div class='itemcard'>
                        <img src='<?= $ItemImage ?>'>
                        <div class="iteminfo">
                            <div>
                                <p><?= $shortenedTitle ?></p>
                                <p class='stocks'>Stocks <?= $Quantity ?></p>
                                <p class='stocks'>Rating <?= $Rating ?></p>
                                <div class='star-rating'>
                                    <?php
                                    for ($i = 5; $i >= 1; $i--) {
                                        if ($Rating >= $i) {
                                            echo "<input type='radio' value='$i' checked><label></label>";
                                        } else {
                                            echo  "<input type='radio' value='$i'><label ></label> ";
                                        }
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="tocart">
                                <h4>₱<?= $Price ?></h4>
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