<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Data Employee";

include ('../layout/header.php');

require_once('../../config.php');

$result = mysqli_query($connect, "SELECT users.employee_id, users.username, 
    users.password, users.status, users.role, employee.* FROM users JOIN employee ON users.employee_id = employee.id");
?>



<div class="page-body">
  <div class="container-xl">

  <a href="<?= base_url('admin/data_employees/addEmployees.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Add Data</span></a>

  <table class="table table-bordered mt-3">
    <tr class="text-center">
      <th>No</th>
      <th>Employee ID Number</th>
      <th>Name</th>
      <th>Username</th>
      <th>Positions</th>
      <th>Role</th>
      <th>Action</th>
    </tr>

    <?php if(mysqli_num_rows($result) === 0) { ?>
      <tr>
        <td colspan="7">Empty data, please add new data!</td>
      </tr>
      <?php }else{ ?>
        <?php $no=1; while($employees = mysqli_fetch_array($result)) : ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $employees['employee_id_number'] ?></td>
            <td><?= $employees['name'] ?></td>
            <td><?= $employees['username'] ?></td>
            <td><?= $employees['positions'] ?></td>
            <td><?= $employees['role'] ?></td>
            <td class="text-center">
              <a href="<?= base_url('admin/data_employees/detailEmployees.php?id=' . $employees['id']) ?>" class="badge badge-pill bg-primary">Detail</a>
              
              <a href="<?= base_url('admin/data_employees/editEmployees.php?id=' . $employees['id']) ?>" class="badge badge-pill bg-primary">Edit</a>
              
              <a href="<?= base_url('admin/data_employees/deleteEmployees.php?id=' . $employees['id']) ?>" class="badge badge-pill bg-danger button-deleted">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>  
      <?php } ?>
  </table>
  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
