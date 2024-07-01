<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Security</title>
    <?php
    include("connect.php");
    include("query.php");
    ?>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/editpass.css">
</head>

<body>
    <?php
    include("header.php");
    include("popups.php");
    ?>
    <br><br>
    <h1 class="center">Change Account Password</h1>
    <section>
        <div class="wrapper" id="w1">
            <form action="changepass.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="wedit">
                    <p class="weform-description">Ensure your account is using a long, random password to stay secure.</p>
                    <div class="weform">
                        <div class="inweform">
                            <div class="weitem">
                                <p>Current Password:</p>
                                <input type="password" name="currentpass" value="" required="">
                            </div>
                            <div class="weitem">
                                <p>New Password:</p>
                                <input type="password" id="newpass" name="newpass" class="password-input" value="" required="">
                            </div>
                            <div class="weitem">
                                <p>Confirm Password:</p>
                                <input type="password" id="confirmpass" name="confirmpass" class="password-input" value="" required="">
                            </div>
                            <p class="email">Use at least 8 characters with a mix of letters, numbers, and symbols.</p>
                            <div class="btn-save">
                                <input type="submit" name="submit" value="Save Changes">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php include("footer.php"); ?>
    <script>
        function validateForm() {
            var newPassword = document.getElementById('newpass').value;
            var confirmPassword = document.getElementById('confirmpass').value;
            var passwordInputs = document.querySelectorAll('.password-input');

            if (newPassword !== confirmPassword) {
                alert("New Password and Confirm Password must match!");
                passwordInputs.forEach(function(element) {
                    element.classList.add('password-mismatch');
                });
                return false;
            } else {
                passwordInputs.forEach(function(element) {
                    element.classList.remove('password-mismatch');
                });
            }

            return true;
        }
    </script>
</body>

</html>