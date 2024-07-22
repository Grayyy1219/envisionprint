<?php
$User = $_GET['UserID'];
$query = "SELECT * FROM users WHERE UserID = $User";

$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$location1 = $row["profile"];
$username1 = $row["username"];
$FName1 = $row["FName"];
$email1 = $row["email"];
$address1 = $row['address'];
$phone1 = $row['phone'];

?>

<link rel="stylesheet" href="css/edituser.css">

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Personalise your account</h3>
            </div>
            <div class="panel-body">
                <div class="body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="wedit">
                            <div class="weditimg">
                                <input type="hidden" name="UserID" value="<?= $User ?>">
                                <div class="profileImage"><img id='profileimg' src='<?= $location1 ?>' alt='Profile Picture'></div>
                                <label class="btn-upload-img">
                                    Upload Profile Picture <input type="file" id="img" name="img" accept="image/*">
                                </label>
                            </div>
                            <div class="weform">
                                <p class="email">Please fill out the information below to update your profile details.</p>
                                <div class="inweform">
                                    <div class="weitem">
                                        <div class="border">
                                            <p>Name:</p>
                                        </div>
                                        <?php
                                        echo "<input type='text' class='input2' name='first_name' value='$FName1'>";
                                        ?>
                                        <p class="email">Enter your full name.</p>

                                    </div>

                                    <div class="weitem">
                                        <div class="border">
                                            <p>Address:</p>
                                        </div>
                                        <?php
                                        echo "<input type='text' class='input2' name='address' value='$address1' title='Enter your current residential address'>";
                                        ?>
                                        <p class="email">Enter your current residential address.</p>

                                    </div>
                                </div>
                                <div class="inweform">
                                    <div class="weitem">
                                        <div class="border">
                                            <p>Email:</p>
                                        </div>
                                        <?php
                                        echo "<input type='text' class='input2' name='email' id='emailInput' value='$email1' style='text-transform: none;' pattern='.*\.com' title='Please enter a valid email address'>";
                                        ?>
                                        <p class="email">Enter a valid email address.</p>

                                    </div>
                                    <div class="weitem">
                                        <div class="border">
                                            <p>Phone:</p>
                                        </div>
                                        <?php
                                        echo "<input type='tel' class='input2' name='phone' value='$phone1' pattern='^(\d{11}|\d{12}|\d{13})?$' title='Enter 11 or 13 digits'>";
                                        ?>
                                        <p class="email">Enter your 11 digit number.</p>

                                    </div>
                                    <label class="btn-save">
                                        <div class="btnsave">
                                            Save Changes <input formaction="adminedituser.php" type="submit" name="submit">
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </form>
                    <script>
                        document.getElementById('img').addEventListener('change', function(event) {
                            const fileInput = event.target;
                            const profileImage = document.getElementById('profileimg');

                            const file = fileInput.files[0];
                            if (file) {
                                profileImage.classList.add('fade-out');

                                setTimeout(() => {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        profileImage.src = e.target.result;
                                        profileImage.classList.remove('fade-out');
                                    };
                                    reader.readAsDataURL(file);
                                }, 300);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>