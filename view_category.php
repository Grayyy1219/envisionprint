<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Item Category Management</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($con, "SELECT * FROM Category ORDER BY CategoryID;");
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $CategoryID  = $row['CategoryID'];
                                    $Category = $row['Category'];
                                    $img = $row['img'];
                                    echo "<tr>";
                                    echo "<td class='td'>$CategoryID</td>";
                                    echo "<td class='td'>$Category</td>";
                                    echo "<td class='td'><img src='$img' alt='image removed: $img' style='width: 100px;'></td>";
                                    echo "<td class='td'><a href='admin.php?edit_category&CategoryID=$CategoryID' style='color: #337ab7; text-decoration: none; '>Edit</a></td>";
                                    echo "<td class='td'><a type='button' onclick='deleteCategory($CategoryID)' style='color: #337ab7; text-decoration: none; '>Delete</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Error: " . mysqli_error($con) . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteCategory(CategoryID) {
        if (confirm("Are you sure you want to delete this Category?")) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                } else if (this.readyState == 4) {
                    console.error('Error:', this.status, this.statusText);
                }
            };
            xhttp.open("POST", "delete_category.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("CategoryID=" + encodeURIComponent(CategoryID));
        }
    }
</script>