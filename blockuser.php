<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Management</title>
    <link rel="stylesheet" href="css/blockuser.css">
    <link rel="icon" href="Image/logo.ico">
</head>
<?php
include("connect.php");
include("query.php");

$query = "SELECT UserID, FName, username, block FROM users WHERE admin != 1";

$result = mysqli_query($con, $query);
?>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">User Account Management</h3>
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
                                    <th>Action</th>
                                    <th>Select</th>
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
                                        echo "<td class='td'><a href='admin2.php?edit_category&GenreID=$userId' style='color: #337ab7; text-decoration: none; margin-right: 10px;'>Edit</a><a type='button' onclick='deleteGenre($userId)' style='color: #337ab7; text-decoration: none; '>Delete</a></td>";
                                        echo "<td class='td'><input type='checkbox' class='delete-checkbox' data-userid='$userId'></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Error: " . mysqli_error($con) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div id="delete">
                            <a href="signup.php"><button class="Signup">Add</button></a>
                            <button class="delete" onclick="deleteSelectedRows()">Delete</button>
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

        function deleteSelectedRows() {
            var selectedCheckboxes = document.querySelectorAll('.delete-checkbox:checked');
            var selectedUserIds = Array.from(selectedCheckboxes).map(function(checkbox) {
                return checkbox.getAttribute('data-userid');
            });

            if (selectedUserIds.length > 0) {
                var confirmed = confirm("Are you sure you want to delete the selected users?");
                if (confirmed) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            if (this.status == 200) {
                                location.reload();
                            } else {
                                // Handle errors here if needed
                                console.error('Error:', this.status, this.statusText);
                            }
                        }
                    };

                    var requestData = "user_ids=" + encodeURIComponent(selectedUserIds.join(','));

                    xhttp.open("POST", "delete_users.php");
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(requestData);
                }
            } else {
                alert("Please select at least one user to delete.");
            }
        }
    </script>
</body>