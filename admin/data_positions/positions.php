<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Data Positions";

include ('../layout/header.php');

require_once('../../config.php');


?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">
 
      
    </div>
  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
