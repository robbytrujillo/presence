<?php 

session_start();
ob_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Add Presence Location";

include ('../layout/header.php');

require_once('../../config.php');

if (isset($_POST['save'])) {
  $name_location = htmlspecialchars($_POST['name_location']);
  $address_location = htmlspecialchars($_POST['address_location']);
  $type_location = htmlspecialchars($_POST['type_location']);
  $latitude = htmlspecialchars($_POST['latitude']);
  $longitude = htmlspecialchars($_POST['longitude']);
  $radius = htmlspecialchars($_POST['radius']);
  $time_zone = htmlspecialchars($_POST['time_zone']);
  $entry_time = htmlspecialchars($_POST['entry_time']);
  $out_time = htmlspecialchars($_POST['out_time']);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      $result = mysqli_query($connect, "INSERT INTO presence_location(name_location, address_location, 
      type_location, latitude, longitude, radius, time_zone, entry_time, out_time) VALUES 
      ('$name_location', '$address_location', '$type_location', '$latitude', '$longitude','$radius',
      '$time_zone','$entry_time','$out_time')");

      $_SESSION['succeed'] = 'Data saved successfully';
      header("Location: presenceLocations.php");
      exit;
    }
  }
}

// $result = mysqli_query($connect, "SELECT * FROM presence_location ORDER BY id DESC");
?>

<div class="page-body">
  <div class="container-xl">

  <div class="card col-md-6">
    <div class="card-body">
        <form action="<?= base_url('admin/data_presence_locations/addPresenceLocations.php') ?>" method="POST">
            <div class="mb-3">
              <label for="">Name Location</label>
              <input type="text" class="form-control" name="name_location" value="<?php if (isset($_POST['name_location'])) echo $_POST['name_location'] ?>">
            </div>

            <div class="mb-3">
              <label for="">Address Location</label>
              <input type="text" class="form-control" name="address_location" value="<?php if (isset($_POST['address_location'])) echo $_POST['address_location'] ?>">
            </div>

            <div class="mb-3">
              <label for="">Type Location</label>
              <select class="form-control" name="type_location">
                <option value="">--Choose Type Location--</option>
                <option <?php if (isset($_POST['type_location']) && $_POST['type_location'] == 'Center') { echo 'selected'; } ?> value="Center">Center</option>
                <option <?php if (isset($_POST['type_location']) && $_POST['type_location'] == 'Branch') { echo 'selected'; } ?> value="Branch">Branch</option>
              </select> 
            </div>

            <div class="mb-3">
              <label for="">Latitude</label>
              <input type="text" class="form-control" name="latitude" value="<?php if (isset($_POST['latitude'])) echo $_POST['latitude'] ?>">
            </div>

            <div class="mb-3">
              <label for="">Longitude</label>
              <input type="text" class="form-control" name="longitude" value="<?php if (isset($_POST['longitude'])) echo $_POST['longitude'] ?>">
            </div>

            <div class="mb-3">
              <label for="">Radius</label>
              <input type="number" class="form-control" name="radius" value="<?php if (isset($_POST['radius'])) echo $_POST['radius'] ?>">
            </div>
            
            <div class="mb-3">
              <label for="">Time Zone</label>
              <select class="form-control" name="time_zone">
                <option value="">--Choose Type Location--</option>
                <option <?php if (isset($_POST['time_zone']) && $_POST['time_zone'] == 'WIB') { echo 'selected'; } ?> value="WIB">WIB</option>
                <option <?php if (isset($_POST['time_zone']) && $_POST['time_zone'] == 'WITA') { echo 'selected'; } ?> value="WITA">WITA</option>
                <option <?php if (isset($_POST['time_zone']) && $_POST['time_zone'] == 'WIT') { echo 'selected'; } ?> value="WIT">WIT</option>
              </select> 
            </div>

            <div class="mb-3">
              <label for="">Entry Time</label>
              <input type="time" class="form-control" name="entry_time" value="<?php if (isset($_POST['entry_time'])) echo $_POST['entry_time'] ?>">
            </div>
            
            <div class="mb-3">
              <label for="">Out Time</label>
              <input type="time" class="form-control" name="out_time" value="<?php if (isset($_POST['out_time'])) echo $_POST['out_time'] ?>">
            </div>

            <button type="submit" class="btn btn-primary" name="save">Save</button>

        </form>

  </div>

  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
