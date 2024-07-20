<style>
    table {
        width: 70%;
    }

    img.slideimg {
        width: 20vw;
    }

    .modal {
        display: none;
        z-index: unset;
        z-index: 999;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
    }

    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        z-index: 2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-radius: 10px;
    }

    #uploadFormPagetab {
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    #uploadFormPagetab input {
        width: 100%;
        padding: 10px;
        margin: 5px 5px;
        box-sizing: border-box;
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        text-align: center;
    }

    input[type="file"],
    input[type="color"],
    input[type="text"] {
        margin: 5px 0;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #uploadFormPagetab img {
        width: 50%;
        margin: 30px;
    }

    .colordiv {
        width: 70px;
        height: 40px;
        /* margin: auto; */
        box-shadow: 2px 2px 5px #888;
        border-radius: 7px;
    }

    .ss {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .row {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }

    .slide {
        width: calc(33.33% - 20px);
        margin: 0 10px;
        text-align: center;
    }

    .slide p {
        margin-top: 10px;
    }

    .slide img {
        cursor: pointer;
    }

    .slide img:hover {
        opacity: 0.8;
    }

    .divide {
        display: flex;
        justify-content: center;
    }

    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        z-index: 2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-radius: 10px;
    }

    .close {
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
    }

    td.td {
        align-content: center;
        text-align: center;
    }
</style>

<div class="divide">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Page Management</h3>
                </div>
                <div class="panel-body">
                    <form method="GET" action="admin2.php">
                        <input type="hidden" name="view_products" value="1">
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Page Item</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = mysqli_query($con, "SELECT * FROM page;");
                                if ($result) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $itemId = $row['ItemID'];
                                        $itemName = $row['Itemname'];
                                        $itemValue = $row['value'];

                                        if ($itemName === "Logo") {
                                            $itemVisual = "<img src='$itemValue' width='70px' alt='Logo'>";
                                        } elseif ($itemName === "Background Color") {
                                            $itemVisual = "<div class='colordiv' style='background-color: $itemValue;'></div>";
                                        } elseif ($itemName === "Text Color") {
                                            $itemVisual = "<div class='colordiv' style='background-color: $itemValue;'></div>";
                                        }

                                        echo "<tr>";
                                        echo "<td class='td'> $itemId </td>";
                                        echo "<td class='td' style='min-width: 150px;'> $itemName </td>";
                                        echo "<td class='td'> $itemVisual </td>";
                                        echo "<td class='td'> <input type='button' name='submitpagetab' class='submit-btn' onclick='openModalpagetab$itemId($itemId)' value='Change'></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Error: " . mysqli_error($con) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Slide Show Management</h3>
                </div>
                <div class="panel-body">
                    <form method="GET" action="admin2.php">
                        <input type="hidden" name="view_products" value="1">
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Silde #</th>
                                    <th>Slide Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = mysqli_query($con, "SELECT * FROM slideshow;");
                                if ($result) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $itemId = $row['SlideID'];
                                        $itemName = $row['imagename'];
                                        $itemValue = $row['imagelocation'];
                                        $itemVisual = "<img class='slideimg' src='$itemValue'  alt='Logo'>";

                                        echo "<tr>";
                                        echo "<td class='td'> $itemId </td>";
                                        echo "<td class='td'> $itemVisual </td>";
                                        echo "<td class='td'> <input type='button' name='submitpagetab' class='submit-btn' onclick='openModal($itemId)' value='Change'></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Error: " . mysqli_error($con) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="Modallogo" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal2()">&times;</span>
        <h2>Upload Image</h2>
        <form id="uploadFormPagetab" action="editpage.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>Logo<input type="text" name="ItemID" readonly style="border: none; font-size: 30px ">
            <p>New image:</p> <img id="previewImage2" src=""><input type="file" name="logo" id="fileInput1" onchange="fileInputChanged2()" style="display: none;">
            <input type="submit" name="logof" value="UPLOAD">
        </form>
    </div>
</div>
<div id="ModalCompanyName" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal2()">&times;</span>
        <h2>Change Company Name</h2>
        <form id="uploadFormPagetab" action="editpage.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>New CompanyName:</p> <input type='text' name='company' id="companyName" placeholder='<?php echo "$companyname"; ?>'>
            <input type='submit' name='companyf' class="submit-btn" value='Change'>
        </form>
    </div>
</div>
<div id="ModalBgImg" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal2()">&times;</span>
        <h2>Upload Image</h2>
        <form id="uploadFormPagetab" action="editpage.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>New Background image:</p> <img id="previewImage3" src=""><input type="file" name="bgimg" id="fileInput2" onchange="fileInputChanged3()" style="display: none;">
            <input type="submit" name="bgimgf" class="submit-btn" value="Change">
        </form>
    </div>
</div>
<div id="ModalBgcolor" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal2()">&times;</span>
        <h2>Change Background Color</h2>
        <form id="uploadFormPagetab" action="editpage.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>New Background Color:</p> <input type='color' name='bgColor' value='<?php echo "$backgroundcolor"; ?>' style="height: 100px;">
            <input type='submit' name='bgcolorf' class="submit-btn" value='Change'>
        </form>
    </div>
</div>
<div id="Modalcolor" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal2()">&times;</span>
        <h2>Change Text Color</h2>
        <form id="uploadFormPagetab" action="editpage.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>New Text Color:</p> <input type='color' name='Color' value='<?php echo "$color"; ?>' style="height: 100px;">
            <input type='submit' name='colorf' class="submit-btn" value='Change'>
        </form>
    </div>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Upload Image</h2>
        <form id="uploadForm" action="slide.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>Slide number<input type=" text" name="slideindex" readonly style="border: none; font-size: 30px">
            </p>
            <p>New image: <img id="previewImage" src=""><input type="file" name="myfile" id="fileInput" onchange="fileInputChanged()" style="display: none;"></p>
            <input type="submit" name="submit" value="UPLOAD">
        </form>
    </div>
</div>
<div id="myModalpagetab" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal2()">&times;</span>
        <h2>Upload Image</h2>
        <form id="uploadFormPagetab" action="editpage.php" method="post" enctype="multipart/form-data" onsubmit="return adminpass2()">
            <p>Logo<input type="text" name="ItemID" readonly style="border: none; font-size: 30px ">
            <p>New image:</p> <img id="previewImage2" src="" width="200"><input type="file" name="logo" id="fileInput2" onchange="fileInputChanged2()" style="display: none;">
            <input type="submit" name="logof" value="UPLOAD">
        </form>
    </div>
</div>
<script>
    function adminpass2() {
        var result = checkAdminPassword();

        if (result === true) {
            return true;
        } else if (result === "canceled") {
            alert("You Canceled.");
            return false;
        } else {
            // Code to execute if the password is incorrect
            alert("Incorrect password.");
            return false;
        }
    }

    function checkAdminPassword() {
        var enteredPassword = prompt("Enter Admin Password:");
        if (enteredPassword === "<?php echo "$hashedadminpassword" ?>") {
            return true; // Password is correct
        } else if (enteredPassword === null) {
            return "canceled"; // User canceled the prompt
        } else {
            return false; // Incorrect password
        }
    }
</script>
<script src="acode.js"></script>