<?php
function getItemDetails($con, $ItemID)
{
    $sql = "SELECT * FROM items WHERE ItemID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $ItemID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $ItemID = isset($_GET["ItemID"]) ? $_GET["ItemID"] : '';
    $ItemDetails = getItemDetails($con, $ItemID);

    if ($ItemDetails) {
        $categoryQuery = "SELECT DISTINCT Category FROM category";
        $categoryResult = mysqli_query($con, $categoryQuery);
        $categorys = [];
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            $categorys[] = $categoryRow['Category'];
        }
    } else {
        echo "Item not found";
        exit;
    }
}
?>
<link rel="stylesheet" href="css/insertform.css">

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Product Form</h3>
            </div>
            <div class="panel-body">
                <div class="insertform">
                    <form class="formdiv" id="editItemForm" method="post" action="" enctype="multipart/form-data">
                        <div class="formsection">
                            <div class="formsectioninside">
                                <div class="sectiondiv">
                                    <div class="sectioninsidediv">
                                        <input type="hidden" name="ItemID" value="<?= $_GET['ItemID'] ?>">
                                        <span>Name:</span>
                                        <input type="text" name="title" value="<?= htmlspecialchars($ItemDetails['ItemName']) ?>">
                                        <p class="tooltiptext">Enter the product name</p>
                                    </div>
                                    <div class="sectioninsidediv">
                                        <span>Category:</span>
                                        <select name="category" id="category">
                                            <?php foreach ($categorys as $category) : ?>
                                                <option value="<?= htmlspecialchars($category) ?>" <?= ($category === $ItemDetails['Category']) ? 'selected' : '' ?>>
                                                    <?= $category ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="tooltiptext">Select the product category</p>
                                    </div>
                                </div>
                                <div class="sectioninsidediv">
                                    <span>Description:</span>
                                    <textarea id="description" name="description" rows="4" cols="50"><?= htmlspecialchars($ItemDetails['Description']); ?></textarea>
                                    <p class="tooltiptext">Enter the product description</p>
                                </div>
                            </div>
                            <div class="sectioninsidediv">
                                <span>Image:</span>
                                <img id='profileImage' src='<?= $ItemDetails['ItemImg'] ?>'>
                                <label class="btn-upload-img">
                                    Upload Image<input type="file" id="img" name="ItemImg" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div class="formsection">
                            <div class="formsectioninside">
                                <div class="sectiondiv">
                                    <div class="sectioninsidediv">
                                        <span>Price:</span>
                                        <input type="text" name="price" value="<?= htmlspecialchars($ItemDetails['Price']); ?>">
                                        <p class="tooltiptext">Enter the product price</p>
                                    </div>
                                    <div class="sectioninsidediv">
                                        <span>Quantity:</span>
                                        <input type="text" name="quantity" value="<?= htmlspecialchars($ItemDetails['Quantity']); ?>">
                                        <p class="tooltiptext">Enter the product quantity</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="submit-btn" onclick="updateItem()" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function updateItem() {
        var form = document.getElementById('editItemForm');
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_item.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Item updated successfully!');
                window.location.href = 'admin.php?view_products';
            } 
        };
        xhr.send(formData);
    }
    document.getElementById('img').addEventListener('change', function(event) {
        const fileInput = event.target;
        const profileImage = document.getElementById('profileImage');

        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>