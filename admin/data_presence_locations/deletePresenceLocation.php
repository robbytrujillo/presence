<?php 

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connect, "DELETE FROM presence_location WHERE `id`='$id'");

$_SESSION['succeed'] = 'Data deleted successfully';
header("Location: presenceLocations.php");
exit;

include('../layout/footer.php');
?>