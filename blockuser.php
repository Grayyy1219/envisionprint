<?php
$query = "SELECT UserID, FName, username, block FROM users WHERE admin != 1";
$result = mysqli_query($con, $query);
?>

<body>
    <?php
    include("popups.php");
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button style="float: inline-end;" onclick="openPopup('SignupPopup')">Add</button>
                    <h3 class="panel-title">User Account Management </h3>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $userId  = $row['UserID'];
                                        $FName = $row['FName'];
                                        $username  = $row['username'];
                                        $block = $row['block'];
                                        echo "<tr id='user-row-$userId'>";
                                        echo "<td class='td'>$userId</td>";
                                        echo "<td class='td'>$FName</td>";
                                        echo "<td class='td'>$username</td>"; ?>
                                        <td>
                                            <?php if ($block == 1) : ?>
                                                <a class="unblock-btn" onclick="handleBlockUnblock(<?= $userId ?>, 'unblock')">Unblock</a>
                                            <?php else : ?>
                                                <a class="block-btn" onclick="handleBlockUnblock(<?= $userId ?>, 'block')">Block</a>
                                            <?php endif; ?>
                                        </td>
                                <?php
                                        echo "<td class='td'><a href='admin.php?edit_user&UserID=$userId' style='color: #337ab7; text-decoration: none; margin-right: 10px;'>Edit</a></td>";
                                        echo "<td class='td'><a href='admin.php?delete_user&UserID=$userId' onclick='return confirmDelete()' style='color: #337ab7; text-decoration: none; '>Delete</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Error: " . mysqli_error($con) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div id="delete">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function handleBlockUnblock(userId, action) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            if (action === 'block') {
                xhttp.open("GET", "block.php?userid=" + userId, true);
                alert('User successfully blocked');
            } else if (action === 'unblock') {
                xhttp.open("GET", "unblock.php?userid=" + userId, true);
                alert('User successfully unblocked');
            }
            xhttp.send();
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this product?');
        }
    </script>
</body>