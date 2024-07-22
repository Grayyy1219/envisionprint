<?php
include("connect.php");
include("query.php");
function getCategoryDetails($con, $CategoryID)
{
    $sql = "SELECT * FROM category WHERE CategoryID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $CategoryID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}
$CategoryID = isset($_GET["CategoryID"]) ? $_GET["CategoryID"] : '';
$CategoryDetails = getCategoryDetails($con, $CategoryID);

if ($CategoryDetails) {
?>
    <link rel="stylesheet" href="css/insertform.css">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Category Form</h3>
                </div>
                <div class="panel-body">
                    <div class="insertform">
                        <form class="formdiv" id="editCategoryForm" method="post" action="update_item.php" enctype="multipart/form-data">
                            <input type="hidden" name="CategoryID" value="<?php echo htmlspecialchars($CategoryDetails['CategoryID']); ?>">
                            <div class="formsection">
                                <div class="formsectioninside">
                                    <div class="sectioninsidediv">
                                        <img id="profileImage" src="<?php echo htmlspecialchars($CategoryDetails['img']); ?>" width="200px">
                                        <label class="btn-upload-img">
                                            Upload Image <input type="file" id="img" name="img" accept="image/*">
                                        </label>
                                    </div>
                                    <div class="sectiondiv">
                                        <div class="sectioninsidediv">
                                            <span>Category:</span>
                                            <input type="hidden" name="oldcategory" value="<?php echo htmlspecialchars($CategoryDetails['Category']); ?>">
                                            <input type="text" name="title" value="<?php echo htmlspecialchars($CategoryDetails['Category']); ?>">
                                            <p class="tooltiptext">Enter the category name</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" class="submit-btn" onclick="updateCategory()" value="Update">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
} else {
    echo "Category not found";
}
?>
<script>
    function updateCategory() {
        var form = document.getElementById('editCategoryForm');
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_category.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Category updated successfully!');
                window.location.href = 'admin.php?view_category';
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