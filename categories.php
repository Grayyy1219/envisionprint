<div id="shop">
    <div class="categories">
        <h1 style="text-transform: uppercase;">Explore all categories</h1>
    </div>
    <div class="shop">
        <?php
        $query = "SELECT * FROM category";
        $result = mysqli_query($con, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categoryName = mysqli_real_escape_string($con, $row['Category']);
                $categoryimg = mysqli_real_escape_string($con, $row['img']);
                $countQuery = "SELECT COUNT(*) FROM items WHERE category = '$categoryName'";
                $countResult = mysqli_query($con, $countQuery);

                if ($countResult) {
                    $totalRecords = mysqli_fetch_row($countResult)[0];

                    echo "<a href='category.php?category=$categoryName'>
                    <div class='category'>
                <img src='$categoryimg'>
                <div>
                    <p style='color: white;font-size: 11px;'>$categoryName</p>
                </div>
            </div>
                </a>";
                } else {
                    echo "Error fetching book count for $categoryName: " . mysqli_error($con);
                }
            }

            echo "";
        } else {
            echo "Error fetching categories from the database: " . mysqli_error($con);
        } ?>
    </div>