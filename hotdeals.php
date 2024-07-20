<?php
if (!isset($_GET['page'])) {
  $_GET['page'] = 1;
}

$imagesPerPage = 8;
$currentPage = $_GET['page'];
$totalRecords = mysqli_num_rows(mysqli_query($con, "SELECT * FROM items WHERE onsale = '1' "));
$totalPages = ceil($totalRecords / $imagesPerPage);
?>

<link rel="stylesheet" href="css/global.css" />
<div class="label">
  <p>Flash Deal</p>
</div>
<form action="" id="myForm" method="post" enctype="multipart/form-data">
  <div class="hotdeals">
    <div class="dealscontainer">
      <?php
      $startIndex = ($currentPage - 1) * $imagesPerPage;
      $stmt = $con->prepare("SELECT * FROM items WHERE onsale = '1' LIMIT ?, ?");
      $stmt->bind_param("ii",  $startIndex, $imagesPerPage);
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
              <p class="stocks"><?= $Quantity ?> item/s left</p>
              <p class="stocks">
                <img src="css/img/star-filled.png" style="width: 12px; height: 12px" />(<?= $Rating ?>)
              </p>
            </div>
            <div class="tocart">
              <h3>₱<?= $Price ?></h3>
              <div class="discountdiv">
                <h5>₱<?= $oldprice ?></h5>
                <p class="discount"><?= number_format($discount, 2) ?>% off</p>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div id='pagination-container_category' class='pageno'><b>Page: </b>
      <?php
      for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'selected-page' : '';
        echo "<a class='pagination-link $activeClass' href='?page=$i'>$i</a>";
      } ?>
    </div>
  </div>
</form>
<style>
  
</style>
<script>
  function submitForm(action) {
    document.getElementById("myForm").action = action;
    document.getElementById("myForm").submit();
  }
</script>