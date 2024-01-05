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

$result = mysqli_query($connect, "SELECT * FROM presence_location ORDER BY id DESC");
?>



<div class="page-body">
  <div class="container-xl">

  <a href="<?= base_url('admin/data_presence_locations/addPresenceLocations.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Add Data</span></a>

  <table class="table table-bordered mt-3">
    <tr class="text-center">
      <th>No</th>
      <th>Name Location</th>
      <th>Type Location</th>
      <th>Latitude/Longitude</th>
      <th>Radius</th>
      <th>Action</th>
    </tr>

    <?php if(mysqli_num_rows($result) === 0) { ?>
      <tr>
        <td colspan="6">Empty data, please add new data!</td>
      </tr>
      <?php }else{ ?>
        <?php $no=1; while($location = mysqli_fetch_array($result)) : ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $location['name_location'] ?></td>
            <td><?= $location['address_location'] ?></td>
            <td><?= $location['latitude'] . '/' . $location['longitude'] ?></td>
            <td><?= $location['radius'] ?></td>
            <td class="text-center">
              <a href="<?= base_url('admin/data_presence_locations/detailPresenceLocation.php?id=' . $location['id']) ?>" class="badge badge-pill bg-primary">Detail</a>
              
              <a href="<?= base_url('admin/data_presence_locations/editPresenceLocation.php?id=' . $location['id']) ?>" class="badge badge-pill bg-primary">Edit</a>
              
              <a href="<?= base_url('admin/data_presence_locations/deletePresenceLocation.php?id=' . $location['id']) ?>" class="badge badge-pill bg-danger button-deleted">Delete</a>
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
