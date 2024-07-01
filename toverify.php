<?php
include("connect.php");
include("query.php"); ?>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        background: none;
        border: none;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    h2 {
        color: var(--primary);
        font-family: Arial, sans-serif;
        text-align: center;
    }

    p {
        font-family: Arial, sans-serif;
        text-align: center;
    }

    input[type="text"] {
        width: calc(100% - 40px);
        padding: 10px;
        margin: 10px 0;
        display: block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        border-radius: 5px;
        margin-left: auto;
        margin-right: auto;
    }

    button {
        background-color: var(--primary);
        color: white;
        padding: 10px 20px;
        margin: 10px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
    }

    button:hover {
        opacity: 0.8;
    }
</style>

<div id="verificationModal" class="modal">
    <div class="modal-content">
        <form action="" class="modal-content" method="post" enctype="multipart/form-data">
            <button class="close" formaction="logout.php">&times;</button>
            <h2>Email Verification Required</h2>
            <p>Your account is not verified yet. Please check your email for the verification link.</p>
            <p>If you did not receive the email, click the button below to resend the verification email.</p>
            <p>Enter the verification code:</p>
            <input type="hidden" name="email" value="<?= $row['Email'] ?>">
            <input type="text" name="code" id="verificationCodeInput" placeholder="Enter code">
            <button id="submitVerificationCode" formaction="process.php">Submit</button>
            <button id="resendVerification" formaction="mail.php">Resend Verification Email</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('verificationModal').style.display = 'block';
    document.querySelector('.close').onclick = function() {
        document.getElementById('verificationModal').style.display = 'none';
    }
</script>