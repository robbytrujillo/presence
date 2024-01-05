<?php 

session_start();
ob_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Edit Data Presence Locations";

include ('../layout/header.php');

require_once('../../config.php');

// cek button submit apakah sudah ditekan atau belum
if (isset($_POST['update'])) {
  // buat variable untuk menampung data yang diinput oleh user
  $id = $_POST['id'];
  $name_location = htmlspecialchars($_POST['name_location']);
  $address_location = htmlspecialchars($_POST['address_location']);
  $type_location = htmlspecialchars($_POST['type_location']);
  $latitude = htmlspecialchars($_POST['latitude']);
  $longitude = htmlspecialchars($_POST['longitude']);
  $radius = htmlspecialchars($_POST['radius']);
  $time_zone = htmlspecialchars($_POST['time_zone']);
  $entry_time = htmlspecialchars($_POST['entry_time']);
  $out_time = htmlspecialchars($_POST['out_time']);

  // pengecekan 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // memastikan inputan kosong
    if (empty($name_location)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Name loc.n is mandatory!";
      }
      if (empty($address_location)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Address loc. is mandatory!";
      }
      if (empty($type_location)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Type loc. is mandatory!";
      }
      if (empty($latitude)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Latitude is mandatory!";
      }
      if (empty($longitude)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Longitude is mandatory!";
      }
      if (empty($radius)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Radius is mandatory!";
      }
      if (empty($time_zone)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Time Zone is mandatory!";
      }
      if (empty($entry_time)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Entry Time is mandatory!";
      }
      if (empty($out_time)) {
        $error_message[] = "<i class='fa-solid fa-check'></i>Out Time is mandatory!";
      }

    if (!empty($error_message)) {
        $_SESSION['validation'] = implode("<br>", $error_message); // ubah array menjadi string
    } else {
      // query
      $result = mysqli_query($connect, "UPDATE presence_location SET 
        name_location='$name_location', 
        address_location='$address_location', 
        type_location='$type_location', 
        latitude='$latitude', 
        longitude='$longitude', 
        radius='$radius', 
        time_zone='$time_zone', 
        entry_time='$entry_time', 
        out_time='$out_time' 
      WHERE `id`='$id'");

      $_SESSION['succeed'] = "Data update successfully";
      // redirect
      header("Location: presenceLocations.php");
      exit;
    }
  }

  
}

// $id = $_GET['id'];
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connect, "SELECT * FROM presence_location WHERE id = $id");

while($location = mysqli_fetch_array($result)) {
    $name_location = $location['name_location'];
    $address_location = $location['address_location'];
    $type_location = $location['type_location'];
    $latitude = $location['latitude'];
    $longitude = $location['longitude'];
    $radius = $location['radius'];
    $time_zone = $location['time_zone'];
    $entry_time = $location['entry_time'];
    $out_time = $location['out_time'];
}

?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

    <div class="card col-md-6">
        <div class="card-body">

        <form action="<?= base_url('admin/data_presence_locations/editPresenceLocation.php') ?>" method="POST">

            <div class="mb-3">
                <label for="">Name Location</label>
                <input type="text" class="form-control" name="name_location" value="<?= $name_location ?>">
            </div>
            
            <div class="mb-3">
                <label for="">Address Location</label>
                <input type="text" class="form-control" name="address_location" value="<?= $address_location ?>">
            </div>
            
            <div class="mb-3">
                <label for="">Type Location</label>
                <select class="form-control" name="type_location">
                    <option value="">--Choose Type Location--</option>
                    <option <?php if ($type_location == 'Center') { echo 'selected'; } ?> value="Center">Center</option>
                    <option <?php if ($type_location == 'Branch') { echo 'selected'; } ?> value="Branch">Branch</option>
                </select>
            </div>
           
            <div class="mb-3">
                <label for="">Latitude</label>
                <input type="text" class="form-control" name="latitude" value="<?= $latitude ?>">
            </div>
            
            <div class="mb-3">
                <label for="">Longitude</label>
                <input type="text" class="form-control" name="longitude" value="<?= $longitude ?>">
            </div>
            
            <div class="mb-3">
                <label for="">Radius</label>
                <input type="text" class="form-control" name="radius" value="<?= $radius ?>">
            </div>
            
            <div class="mb-3">
                <label for="">Time Zone</label>
                <select class="form-control" name="time_zone">
                    <option value="">--Choose Time Zone--</option>
                    <option <?php if ($time_zone == 'WIB') { echo 'selected'; } ?> value="WIB">WIB</option>
                    <option <?php if ($time_zone == 'WITA') { echo 'selected'; } ?> value="WITA">WITA</option>
                    <option <?php if ($time_zone == 'WIT') { echo 'selected'; } ?> value="WIT">WIT</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="">Entry Time</label>
                <input type="text" class="form-control" name="entry_time" value="<?= $entry_time ?>">
            </div>
            
            <div class="mb-3">
                <label for="">Out Time</label>
                <input type="text" class="form-control" name="out_time" value="<?= $out_time ?>">
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
