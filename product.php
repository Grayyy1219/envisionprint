<?php
include("connect.php");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

function getSearchResults($searchValue, $con)
{
    $searchQuery = "SELECT * FROM items WHERE ItemName LIKE '%$searchValue%'";
    $result = mysqli_query($con, $searchQuery);

    $txt = "";
    if (mysqli_num_rows($result) > 0) {
        $displayedItems = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($displayedItems >= 8) {
                break;
            }
            $ItemID = $row['ItemID'];
            $name = $row['ItemName'];
            $rating = formatPrice($row['rating']);
            $location = $row['ItemImg'];
            $category = $row['Category'];
            $Price = $row['Price'];
            $oldprice = $row['oldprice'];
            $Solds = $row['Solds'];
            $Quantity = $row['Quantity'];

            $discount = 0;
            if ($oldprice > 0) {
                $discount = (($oldprice - $Price) / $oldprice) * 100;
            }

            $txt .= "<a href='itempage.php?ItemID=$ItemID'>
    <div class='itemdeal' onclick='submitForm(\"itempage.php?ItemID=$ItemID\")'>
        <div class='imgdeal'>
            <img src='$location' alt=''>
        </div>
        <div class='iteminfo'>
            <div>
                <p>$name</p>
                <p class='stocks'>$Quantity item/s left</p>
                <p class='stocks'>
                    <img src='css/img/star-filled.png' style='width: 12px; height: 12px'>($rating)
                </p>
            </div>
            <div class='tocart'>
                <h3>₱$Price</h3>";

            if ($row['onsale'] == 1) {
                $txt .= "<div class='discountdiv'>
                    <h5>₱" . number_format($oldprice, 2) . "</h5>
                    <p class='discount'>" . number_format($discount, 2) . "% off</p>
                </div>";
            }

            $txt .= "</div>
        </div>
    </div>
</a>";
            $displayedItems++;
        }
    } else {
        $txt .= "<h1>No Data Found</h1>";
    }
    return $txt;
}

function formatPrice($number)
{
    return number_format($number, 2);
}

if (isset($_GET['search'])) {
    $searchValue = $_GET['search'];
    $searchResults = getSearchResults($searchValue, $con);
    echo $searchResults;
}

mysqli_close($con);
