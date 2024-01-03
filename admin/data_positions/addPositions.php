<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Add Data Positions";

include ('../layout/header.php');

require_once('../../config.php');


?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

    <div class="card col-md-6">
        <div class="card-body">

        <form action="<?= base_url('admin/data_positions/addPositions.php') ?>" method="post">
            <div class="mb-3">
                <label for="">Name Position</label>
                <input type="text" class="form-control" name="positions">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Save</button>
        </form>

        </div>
    </div>
  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
