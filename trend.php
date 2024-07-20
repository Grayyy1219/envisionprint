<link rel="stylesheet" href="css/global.css" />
<div class="label">
  <p>#Just for You Trend</p>
</div>
<form action="" id="myForm" method="post" enctype="multipart/form-data">
  <div class="hotdeals">
    <div class="dealscontainer">
      <?php
      $startIndex = ($currentPage - 1) * $imagesPerPage;
      $stmt = $con->prepare("SELECT * FROM items ORDER BY Solds DESC LIMIT 4");
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
        <div class="itemdeal" onclick="submitForm('itempage.php?ItemID=<?= $ItemID ?>')">
          <div class="imgdeal">
            <img src="<?= $ItemImage ?>" alt="" />
          </div>
          <div class="iteminfo">
            <div>
              <p><?= $ItemName ?></p>
              <p class="stocks"><?= $Solds ?> Solds</p>
              <p class="stocks">
                <img src="css/img/star-filled.png" style="width: 12px; height: 12px" />(<?= $Rating ?>)
              </p>
            </div>
            <div class="tocart">
              <h3>₱<?= $Price ?></h3>
              <?php
              if ($row['onsale'] == 1) { ?>
                <div class="discountdiv">
                  <h5>₱<?= $oldprice ?></h5>
                  <p class="discount"><?= number_format($discount, 2) ?>% off</p>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</form>