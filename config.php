<?php 

$db_bost = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "presence";

$connect = mysqli_connect($db_bost, $db_user, $db_password, $db_name);

if (!$connect) {
    echo "Database Connection Failed" . mysqli_connect_error();
}

function base_url($url = null) {
    $base_url = 'http://localhost/presence/';

    if ($url != null) {
        return $base_url . '/' .$url;
    } else {
        return $base_url;
    }
}

?>