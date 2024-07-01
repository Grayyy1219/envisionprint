<?php
if (isset($_POST['code'])) {
    $code = urlencode($_POST['code']);
    header("Location: http://localhost/envisionprint/verify.php?code=$code");
    exit();
} else {
    echo "Code parameter is missing!";
}
