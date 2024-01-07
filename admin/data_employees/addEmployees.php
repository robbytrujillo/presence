<?php 

session_start();
ob_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Add Employee";

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
        <form action="<?= base_url('admin/data_employees/addEmployees.php') ?>" method="POST">
         
        <!--automation add Employee ID Number  -->
        <?php 
        $take_employee_id_number = mysqli_query($connect, "SELECT employee_id_number FROM employee ORDER BY employee_id_number DESC LIMIT 1");

        if (mysqli_num_rows($take_employee_id_number) > 0) {
          $row = mysqli_fetch_assoc($take_employee_id_number);
          $employee_id_number_db = $row['employee_id_number'];
          $employee_id_number_db = explode("-", $employee_id_number_db);
          $new_number = (int)$employee_id_number_db[1] + 1;
          $new_employee_id_number = "EMP-" . str_pad($new_number, 4, 0, STR_PAD_LEFT);
        } else {
          $new_employee_id_number = "EMP-0001";
        }
        
        ?>    
        
        <div class="mb-3">
              <label for="">Employee ID Number</label>
              <input type="text" class="form-control" name="employee_id_number" value="<?= $new_employee_id_number ?>">
            </div>

            <div class="mb-3">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name'] ?>">
            </div>

            <div class="mb-3">
              <label for="">Gender</label>
              <select class="form-control" name="gender">
                <option value="">--Choose Gender--</option>
                <option <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Male') { echo 'selected'; } ?> value="Male">Male</option>
                <option <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Female') { echo 'selected'; } ?> value="Female">Female</option>
              </select> 

            </div>

            <div class="mb-3">
              <label for="">Address</label>
              <input type="text" class="form-control" name="address" value="<?php if (isset($_POST['address'])) echo $_POST['address'] ?>">
            </div>

            <div class="mb-3">
              <label for="">Position</label>
              <select class="form-control" name="positions">
                <option value="">--Choose Gender--</option>
                <?php 
                $take_position = mysqli_query($connect, "SELECT * position ORDER BY positions ASC");

                while ($positions = mysqli_fetch_assoc($take_position)) {
                  $name_position = $positions['positions'];

                  if (isset($_POST['positions']) && $_POST['positions'] == $name_position){
                    echo '<option value="'.$name_position.'" selected = "selected">' . $name_position. '</option>';
                  } else {
                    echo '<option value="' .$name_position . '">' . $name_position . '</option>';                 }
                }
                
                ?>
              </select> 
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
