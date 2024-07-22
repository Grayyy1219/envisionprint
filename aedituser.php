<link rel="stylesheet" href="css/edituser.css">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Personalise your account</h3>
            </div>
            <div class="panel-body">
                <div class="body">
                    <section></a>

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="wedit">
                                <div class="weditimg">

                                    <div class="profileImage"><img id='profileimg' src='<?= $location ?>' alt='Profile Picture'></div>
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
                                            echo "<input type='text' class='input2' name='first_name' value='$FName'>";
                                            ?>
                                            <p class="email">Enter your full name.</p>

                                        </div>

                                        <div class="weitem">
                                            <div class="border">
                                                <p>Address:</p>
                                            </div>
                                            <?php
                                            echo "<input type='text' class='input2' name='address' value='$address' title='Enter your current residential address'>";
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
                                            echo "<input type='text' class='input2' name='email' id='emailInput' value='$email' style='text-transform: none;' pattern='.*\.com' title='Please enter a valid email address'>";
                                            ?>
                                            <p class="email">Enter a valid email address.</p>

                                        </div>
                                        <div class="weitem">
                                            <div class="border">
                                                <p>Phone:</p>
                                            </div>
                                            <?php
                                            echo "<input type='tel' class='input2' name='phone' value='$phone' pattern='^(\d{11}|\d{12}|\d{13})?$' title='Enter 11 or 13 digits'>";
                                            ?>
                                            <p class="email">Enter your 11 digit number.</p>

                                        </div>
                                        <label class="btn-save">
                                            <div class="btnsave">
                                                Save Changes <input formaction="updateuser.php" type="submit" name="submit">
                                            </div>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </section>
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