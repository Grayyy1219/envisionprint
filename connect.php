<?php
$configContent = file_get_contents('config/config.json');
$config = json_decode($configContent, true);

$dbHost = $config['db_host'];
$dbUser = $config['db_user'];
$dbPass = $config['db_pass'];
$dbName = $config['db_name'];

$con = mysqli_connect($dbHost, $dbUser, $dbPass);

if (!$con) {
    echo "Could not connect! " . mysqli_error($con);
    exit();
}

if (!mysqli_select_db($con, $dbName)) {
    echo "Could not select database! " . mysqli_error($con);
    exit();
}

