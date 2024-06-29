<nav>
    <div class="header">
        <div class="logo">
            <a href='Landingpage.php#'>
                <img src='<?= $logo ?>' height='55px'>
                <h1>Envision Print</h1>
            </a>
        </div>

        <div class="searchbar">
            <input type="text" class="searchinp searchbar" id="searchbar" onchange="loadXMLDoc('search')" placeholder=" Search">
            <button class="searchbtn"><img src="css/img/searchicon.png" width="25" style="filter: invert(1);"></button>
        </div>

        <?php
        $query = mysqli_query($con, "select * from currentuser where UserID = '1'");
        $row = mysqli_fetch_assoc($query);
        $location = $row["profile"];
        $username = $row["username"];
        $FName = $row["FName"];
        $email = $row["email"];

        if ($username == "0") {
            echo "<div class='login'>
             <div class='pointer' id='popup-signin'>
                 <img src='css/img/login.png' height='15'>
                 <p class='loginb'>Sign in</p>
             </div>
             <div>|</div>
             <div class='pointer' id='popup-create'>
              <img src='css/img/createacc.png'height='15'>
                 <p class='signupb'>Create Account</p>
             </div>
         </div>";
        } else {
            echo "<div class='profile'>
                            <img src='$location' width='35' height='35' id='currentuser'>
                    <div id='inout'>
                        <p class='name'><b>$FName</b></p>
                        <p class='email'>$email</p>
                    </div>
                        <div class='carts'>
                        <a href='cart.php'><img src='css/img/shopping-cart.png' width='22' id='currentuser'><div class='cartcount'>$cartcount</div></a>
                        <a onclick='showSettingsPopup()'><img src='css/img/setting.png' width='22' id='profile'>";
            if ($verification != 1) {
                echo "<div class='verify'>Verify</div></a>";
            }
            echo "</a></div></div>";
        }
        ?>
    </div>
    <div class="output" style="display: none;">
        <div id="demo">
        </div>
    </div>
</nav>