<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <?php include("connect.php");
    $ItemID = $_GET["ItemID"];
    $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
    $stmt->bind_param("i", $ItemID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $ItemName = $row["ItemName"];
    $category = $row["Category"];
    $ItemImage = $row["ItemImg"];
    $Price = $row["Price"];
    $Solds = $row["Solds"];
    $Quantity = $row["Quantity"];
    $Description = $row["Description"];
    $shortenedTitle = (strlen($ItemName) > 100) ? substr($ItemName, 0, 100) . '...' : $ItemName;
    ?>
    <title><?= $ItemName ?></title>
    <?php
    include("query.php"); ?>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/itempage.css">
   
</head>

<body>
    <?php
    include("header.php");
    ?>
    <section class="center">
        <form id="myForm" action='' method='post' enctype='multipart/form-data'>
            <div class="itemdiv">
                <div class="itemimg">
                    <div><img loading="lazy" src="<?php echo "$ItemImage"; ?>" height="100px" class="img"></div>
                    <div class="smallitemimg">
                        <img loading="lazy" src="<?php echo "$ItemImage"; ?>">
                        <img loading="lazy" src="<?php echo "$ItemImage"; ?>">
                        <img loading="lazy" src="<?php echo "$ItemImage"; ?>">
                        <img loading="lazy" src="<?php echo "$ItemImage"; ?>">
                    </div>
                </div>
                <div class="iteminfo">
                    <p class="category"><?= $category ?></p>
                    <div class="info">
                        <input type='hidden' name='Title' value='<?= $ItemName ?>'>
                        <div>
                            <p class="Title"><b><?= $shortenedTitle ?></b></p>
                            <p>Qty. (<?= $Quantity ?>)</p>
                        </div>
                        <div class="desc">
                            <p class="desc"><?= $Description ?></p>
                        </div>

                        <?php
                        $initialQuantityValue = 1;
                        ?>
                        <div class="count">
                            <div class="email">Price: <p>₱<?= $Price ?></p>
                            </div>
                            <div class="email">Quantity: <br> <input type='number' value='<?= $initialQuantityValue ?>' name='quantity' id='quantityInput' min='1' max='<?= $Quantity ?>'></div>
                        </div>

                        <div class='cartbtn'>
                            <div class='addtocart' onclick="submitForm('addToCart.php')"><input type='submit' value='Add to Basket' style='all:unset'></div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
    <script>
        function submitForm(action) {
            document.getElementById("myForm").action = action;
            document.getElementById("myForm").submit();
        }
    </script>
    <?php include("footer.php"); ?>
</body>

</html>