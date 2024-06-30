<div class="popup-overlay"></div>
<div id="spopup-overlay"></div>
<div id="SettingsPopup" class="spopup">
    <div class="popup-content">
        <span class="close" onclick="closeSettingsPopup()"><b>&times;</b></span>
        <div class="sdiv">
            <!-- <form action="" class="settings" method="post" enctype="multipart/form-data"> -->
            <?php
            echo "<div class='profileimg'><p><img  src='$location' width='200' height='200' style='object-fit: cover;'></p><br><br>";
            echo "<p class='name'><b>" . $FName . "</b></p>";
            echo "<p class='emaillink'>" . $email . "</p></div>";
            ?>
            <div class="ssbuttons">
                <div class="settingbtn">
                    <a href="edituser.php">
                        <div class="inbtn">
                            <p style="color: white;">Edit Basic Information</p>
                        </div>
                    </a>
                    <a href="editpass.php">
                        <div class="inbtn">
                            <p style="color: white;">Change Password</p>
                        </div>
                    </a>
                    <a href="history.php">
                        <div class="inbtn">
                            <p style="color: white;">Purchase History</p>
                        </div>
                    </a>
                    <?php
                    if ($verification != 1) {
                        echo "
    <div class='verifiydiv'>
        <form action='process.php' method='GET'>
            <input type='text' name='code' placeholder='Enter Code' required>
        </form>
        <a href='mail.php' class='mail-link'>
            <div class='inbtn'>
                <p style='color: white;'>Resend</p>
            </div>
        </a>
    </div>";
                    }
                    ?>

                </div>

                <a href="logout.php">
                    <div class="LogOut">
                        <p>Log Out</p>
                    </div>
                </a>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<div id="LoginPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeLoginPopup()"><b>&times;</b></span>
        <div class="form-box">
            <form action="checkuser.php" class="form" method="post" enctype="multipart/form-data">
                <span class="title">Envision Print</span>
                <div class="form-container">
                    <span class="subtitle">Welcome back! Please sign in to your account.</span>
                    <input type="text" class="input2" id="user" name="user" placeholder="Username" required>
                    <input type="password" class="input2" name="pass" placeholder="Password" required>
                </div>
                <input type="submit" class="submit" name="submit" value="Login">
            </form>
            <div class="form-section">
                <p>Don't have an account? <a href="#" class='ssignupb'>Sign up</a></p>
            </div>
            <div class="form-section">
                <p><a href="forgetpage.php" class='aforgot'>Forgot password?</a></p>
            </div>
        </div>
    </div>
</div>
<div id="SignupPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeSignupPopup()"><b>&times;</b></span>
        <div class="form-box">
            <form action="createuser.php" class="form" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <span class=" title">Sign Up</span>
                <div class="form-container">
                    <span class="subtitle">Create a free account with your details.</span>

                    <div class="input-row">
                        <input type="text" class="input2" placeholder="First Name" name="txtfname" required>
                        <input type="text" class="input2" placeholder="Last Name" name="txtlname" required>
                    </div>
                    <input type="text" class="input2" placeholder="Username" name="txtusername" required>
                    <input type="password" class="input2" placeholder="Password" name="txtpassword" id="password" required>
                    <input type='password' class='input2' placeholder='Confirm Password' name='txtcpassword' id="confirmPassword" required>
                    <input type="email" class="input2" placeholder="Email" name="txtemail" required>
                </div>
                <input type="submit" class="submit" name="submit" value="Sign Up">
                <div class="form-section">
                    <p>Already have an account? <a href="#" class='sloginb'>Log In</a></p>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        // Check if the passwords match
        if (password !== confirmPassword) {
            alert("Passwords do not match. Please make sure both passwords are the same.");
            return false; // Prevent form submission
        }
        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false; // Prevent form submission
        }
        // If passwords match, allow form submission
        return true;
    }

    function toverify() {
        alert("Please Log in into a Verified account first!");
    }

    function openPopup(popupId) {
        // Close any open popups and overlay with fade-out effect
        var openElements = document.querySelectorAll('.popup, .popup-overlay');
        openElements.forEach(function(element) {
            element.style.opacity = 0;
            setTimeout(function() {
                element.style.display = 'none';
            }, 150);
        });

        // Open the selected popup and overlay with fade-in effect
        var overlay = document.querySelector('.popup-overlay');
        var popup = document.getElementById(popupId);
        setTimeout(function() {
            overlay.style.display = 'block';
            popup.style.display = 'block';
            setTimeout(function() {
                overlay.style.opacity = 1;
                popup.style.opacity = 1;
            }, 10);
        }, 150);
    }

    function closePopup(popupId) {
        // Close the popup and overlay with fade-out effect
        var elementsToClose = document.querySelectorAll('.popup, .popup-overlay');
        elementsToClose.forEach(function(element) {
            element.style.opacity = 0;
            setTimeout(function() {
                element.style.display = 'none';
            }, 300);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var loginBtn = document.querySelector('.loginb');
        var signupBtn = document.querySelector('.signupb');
        var sloginBtn = document.querySelector('.sloginb');
        var ssignupBtn = document.querySelector('.ssignupb');
        loginBtn.addEventListener('click', function() {
            openPopup('LoginPopup');

        });

        signupBtn.addEventListener('click', function() {
            openPopup('SignupPopup');
        });
    });

    function closeLoginPopup() {
        document.getElementById('LoginPopup').style.display = 'none';
        var overlay = document.querySelector('.popup-overlay');
        overlay.style.opacity = 0;
        setTimeout(function() {
            overlay.style.display = 'none';
        }, 300);
    }

    function closeSignupPopup() {
        document.getElementById('SignupPopup').style.display = 'none';
        var overlay = document.querySelector('.popup-overlay');
        overlay.style.opacity = 0;
        setTimeout(function() {
            overlay.style.display = 'none';
        }, 300);
    }

    function closeSettingsPopup() {
        document.getElementById('SettingsPopup').style.display = 'none';
        var overlay = document.querySelector('.popup-overlay');
        overlay.style.opacity = 0;
        setTimeout(function() {
            overlay.style.display = 'none';
        }, 300);
    }

    function showSettingsPopup() {
        document.getElementById("SettingsPopup").style.display = "block";
        setTimeout(function() {
            document.getElementById("spopup-overlay").style.display = "block";
        }, 10);
    }

    function closeSettingsPopup() {
        document.getElementById("spopup-overlay").style.display = "none";
        document.getElementById("SettingsPopup").style.display = "none";
    }
    document.addEventListener('keyup', function(event) {
        if (event.key === 'Escape') {
            closeLoginPopup();
            closeSignupPopup();
            closeSettingsPopup();
        }
    });
</script>