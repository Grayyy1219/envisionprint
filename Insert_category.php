<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Category = isset($_POST["categorytxt"]) ? $_POST["categorytxt"] : '';

    if (isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
        $name = $_FILES['img']['name'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $location = "upload/category/$name";
        if (move_uploaded_file($tmp_name, $location)) {
            $img = $location;
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        $img = "default_image_path.jpg";
    }

    addCategory($con, $Category, $location);
}

function addCategory($con, $Category, $location)
{
    $sql = "INSERT INTO Category (Category , img) VALUES (?, ?);";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $Category, $location);

    try {
        $stmt->execute();
        echo "<script>alert('Category added successfully!');</script>";
        echo "<script>window.location.href = 'admin.php?view_category';</script>";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "<script>alert('Category already exists!');</script>";
        } else {
            echo "Error adding Category: " . $e->getMessage();
        }
    }
    $stmt->close();
}
?>
<link rel="stylesheet" href="css/insertform.css">

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Add Category Form</h3>
        </div>
        <div class="panel-body">
            <div class="insertform">
                <form class="formdiv" method="post" action="" enctype="multipart/form-data">
                    <div class="formsection">
                        <div class="formsectioninside">
                            <div class="sectioninsidediv">
                                <img id='profileImage'>
                                <label class="btn-upload-img">
                                    Upload Image<input type="file" id="img" name="img" accept="image/*">
                                </label>
                            </div>
                            <div class="sectiondiv">
                                <div class="sectioninsidediv">
                                    <span>Category:</span>
                                    <input type="text" name="categorytxt" value="" required>
                                    <p class="tooltiptext">Enter the category name</p>
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