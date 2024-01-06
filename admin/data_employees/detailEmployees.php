<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Detail Employee";

include ('../layout/header.php');

require_once('../../config.php');

$result = mysqli_query($connect, "SELECT users.employee_id, users.username, 
    users.password, users.status, users.role, employee.* FROM users JOIN employee ON users.employee_id = employee.id");
?>