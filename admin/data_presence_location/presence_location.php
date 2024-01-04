<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Data Presence Location";

include ('../layout/header.php');

require_once('../../config.php');

$result = mysqli_query($connect, "SELECT * FROM position ORDER BY id DESC");


?>