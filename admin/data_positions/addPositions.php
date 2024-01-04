<?php 

session_start();
ob_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Add Data Positions";

include ('../layout/header.php');

require_once('../../config.php');

// cek button submit apakah sudah ditekan atau belum
if (isset($_POST['submit'])) {
  // buat variable untuk menampung data yang diinput oleh user
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
      $result = mysqli_query($connect, "INSERT INTO `position` (`positions`) VALUES ('$positions')");

      $_SESSION['succeed'] = "Data positions saved successfully";
      // redirect
      header("Location: positions.php");
      exit;
    }
  }

  
}

?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

    <div class="card col-md-6">
        <div class="card-body">

        <form action="<?= base_url('admin/data_positions/addPositions.php') ?>" method="POST">

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
