<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Detail Presence Location";

include ('../layout/header.php');

require_once('../../config.php');

$result = mysqli_query($connect, "SELECT * FROM presence_location ORDER BY id DESC");
?>