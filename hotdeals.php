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
  .dealscontainer {
    display: flex;
    width: 100%;
    justify-content: flex-start;
    gap: 10px;
    border-radius: 10px;
    flex-wrap: wrap;
  }

  .hotdeals {
    width: 80%;
    margin: auto;
    display: flex;
    flex-direction: column;
    padding: 20px;
    background-color: white;
    gap: 10px;
    border-radius: 0 0 15px 15px;
  }

  .imgdeal img {
    height: 100px;
    aspect-ratio: 1/1;
    object-fit: cover;
    border: solid 1px #b1aeae;
    border-radius: 10px;
  }

  .label {
    width: 80%;
    margin: auto;
    border-bottom: 1px solid #d5d5d5;
    background-color: white;
    padding: 10px;
    border-radius: 5px 5px 0 0;
  }

  .label p {
    font-size: 22px;
    text-align: start;
    color: #333;
  }

  .imgdeal {
    display: flex;
    align-items: center;
  }

  .dealscontainer {
    display: flex;
    gap: 10px;
  }

  .itemdeal {
    display: flex;
  }

  .iteminfo p {
    font-size: 12px;
  }

  .stocks {
    display: flex;
    align-items: center;
    gap: 3px;
  }

  p.stocks {
    color: #6d6d6d;
    font-size: 10px;
  }

  .itemdeal {
    display: flex;
    border: solid 1px #d3d0d0;
    padding: 5px;
    width: 252.3px;
    gap: 5px;
  }

  .tocart h5 {
    color: #888;
    text-decoration: line-through;
  }

  .discountdiv {
    display: flex;
    gap: 5px;
  }

  .discount {
    color: var(--primary);
    font-weight: bold;
  }

  .buy {
    background: var(--primary);
    padding: 5px;
    width: 80px;
    color: white;
    border-radius: 3px;
    /* margin-left: auto; */
  }

  div#pagination-container_category {
    display: flex;
    gap: 11px;
    align-items: center;
    margin: auto;
  }

  a.pagination-link {
    padding: 4px 9px;

    border: solid 1px var(--secondary);
    border-radius: 5px;
  }

  .selected-page {
    color: white;
    background: var(--primary);
    font-weight: bold;
  }

  .search_count {
    margin: 0 0 25px 10px;
  }
</style>
<script>
  function submitForm(action) {
    document.getElementById("myForm").action = action;
    document.getElementById("myForm").submit();
  }
</script>