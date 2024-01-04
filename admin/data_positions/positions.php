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

$result = mysqli_query($connect, "SELECT * FROM position ORDER BY id DESC");


?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

  <a href="<?= base_url('admin/data_positions/addPositions.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Add Data</span></a>

    <div class="row row-deck row-cards mt-1">

    <table class="table table-bordered">
      <tr class="text-center">
        <th>No.</th>  
        <th>Name Position</th>  
        <th>Action</th>  
      </tr>

      <?php if(mysqli_num_rows($result) === 0) : ?>
        <tr>
          <td colspan="3">The data is still empty, please add new data</td>
        </tr>  
      <?php else : ?>
        <?php $no=1; while($positions = mysqli_fetch_array($result)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $positions['positions'] ?></td>
            <td class="text-center">
              <a href="<?= base_url('admin/data_positions/editPositions.php?id=' .$positions['id']) ?>" class="badge bg-primary badge-pill">Edit
              
              <a href="<?= base_url('admin/data_positions/deletePositions.php?id=' .$positions['id']) ?>" class="badge bg-danger badge-pill button-deleted">Delete
            </td>
          </tr>
        <?php endwhile; ?>

        <?php endif; ?>
    </table>
      
    </div>
  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
