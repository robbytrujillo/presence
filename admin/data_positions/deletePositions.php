<?php 

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connect, "DELETE FROM position WHERE `id`='$id'");

$_SESSION['succeed'] = 'Data deleted successfully';
header("Location: positions.php");
exit;

include('../layout/footer.php');
?>