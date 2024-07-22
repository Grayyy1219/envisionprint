<?php
$categoryQuery = "SELECT DISTINCT Category FROM category ";
$categoryResult = mysqli_query($con, $categoryQuery);
$categorys = [];
while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
    $categorys[] = $categoryRow['Category'];
}
?>
<link rel="stylesheet" href="css/insertform.css">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add Product Form</h3>
            </div>
            <div class="panel-body">
                <div class="insertform">
                    <form class="formdiv" method="post" action="process_add_products.php" enctype="multipart/form-data">
                        <div class="formsection">
                            <div class="formsectioninside">
                                <div class="sectiondiv">
                                    <div class="sectioninsidediv">
                                        <span>Name:</span>
                                        <input type="text" name="title">
                                        <p class="tooltiptext">Enter the product name</p>
                                    </div>
                                    <div class="sectioninsidediv">
                                        <span>Category:</span>
                                        <select name="category" id="category">
                                            <?php foreach ($categorys as $category) : ?>
                                                <option value="<?= $category ?>" <?= $category ?>>
                                                    <?= $category ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="tooltiptext">Select the product category</p>
                                    </div>
                                </div>
                                <div class="sectioninsidediv">
                                    <span>Description:</span>
                                    <textarea id="description" name="description" rows="4" cols="50"></textarea>
                                    <p class="tooltiptext">Enter the product description</p>
                                </div>
                            </div>
                            <div class="sectioninsidediv">
                                <span>Image:</span>
                                <img id='profileImage' src=''>
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
                                        <input type="text" name="price">
                                        <p class="tooltiptext">Enter the product price</p>
                                    </div>
                                    <div class="sectioninsidediv">
                                        <span>Quantity:</span>
                                        <input type="text" name="quantity">
                                        <p class="tooltiptext">Enter the product quantity</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="submit-btn" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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