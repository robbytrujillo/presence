<?php 

session_start();
ob_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Edit Data Positions";

include ('../layout/header.php');

require_once('../../config.php');

// cek button submit apakah sudah ditekan atau belum
if (isset($_POST['update'])) {
  // buat variable untuk menampung data yang diinput oleh user
  $id = $_POST['id'];
  $positions = htmlspecialchars($_POST['positions']);

  // pengecekan 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // memastikan inputan kosong
    if (empty($positions)) {
      $error_message = " Name Position is require";
    }

    if (!empty($error_message)) {
      $_SESSION['validation'] = $error_message;
    } else {
      // query
      $result = mysqli_query($connect, "UPDATE `position` SET `positions`='$positions' WHERE `id`='$id'");

      $_SESSION['succeed'] = "Data update successfully";
      // redirect
      header("Location: positions.php");
      exit;
    }
  }

  
}

// $id = $_GET['id'];
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connect, "SELECT * FROM position WHERE id = $id");

while($positions = mysqli_fetch_array($result)) {
    $name_positions = $positions['positions'];
}

?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

    <div class="card col-md-6">
        <div class="card-body">

        <form action="<?= base_url('admin/data_positions/editPositions.php') ?>" method="POST">

            <div class="mb-3">
                <label for="">Name Position</label>
                <input type="text" class="form-control" name="positions" value="<?= $name_positions ?>">
            </div>
            <input type="hidden" value="<?= $id ?>" name="id">

            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>

        </div>
    </div>
  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
