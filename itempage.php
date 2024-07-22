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
    $Rating = $row["rating"];
    $rating_count = $row["rating_count"];
    $Description = $row["Description"];
    $customizable = $row["customizable"];
    $shortenedTitle = (strlen($ItemName) > 100) ? substr($ItemName, 0, 100) . '...' : $ItemName;
    ?>
    <title><?= $ItemName ?></title>
    <?php
    include("query.php"); ?>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/itempage.css">
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
            background: url('css/img/star-empty.png') no-repeat;
            background-size: contain;
        }

        .star-rating input:checked~label {
            background: url('css/img/star-filled.png') no-repeat;
            background-size: contain;
        }

        input:disabled {
            all: unset;
            text-align: center;
            width: 110px;
            height: 35px;

            border-radius: 3px;
            background-color: #757373;
            color: #fff;
            cursor: not-allowed;
        }

        label.btn-upload-img.addtocart {
            margin: 0 5px;
            padding: 10px 0;
            border: 1px solid var(--primary);
            font-size: 12px;
            transition: all 0.2s ease-in;
        }

        .btn-upload-img input {
            display: none;
        }
    </style>
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
                            <div class='star-rating'>
                                <?php
                                echo "($rating_count) ";
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
                            <?php if ($customizable == 1) { ?>
                                <label class="btn-upload-img addtocart">
                                    Upload<input type="file" onchange="buttoneable()" id="img" name="img" accept="image/*">
                                </label>
                                <div class='' onclick="submitForm('addToCart.php')"><input type='button' class="addtocart" id="addtocartbtn" value='Add to Basket' disabled></div>
                            <?php } else { ?>
                                <div class='addtocart' onclick="submitForm('addToCart.php')"><input type='button' id="addtocartbtn" value='Add to Basket' style='all:unset'></div>
                            <?php } ?>


                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
    <script>
        function submitForm(action) {
            <?php
            if ($username == 0) {
                echo "toverify();";
            } else {
            ?>
                document.getElementById("myForm").action = action;
                document.getElementById("myForm").submit();
            <?php } ?>
        }

        function buttoneable() {
            var button = document.getElementById('addtocartbtn');
            button.disabled = false;
        }
    </script>
    <?php include("footer.html"); ?>
</body>

</html>