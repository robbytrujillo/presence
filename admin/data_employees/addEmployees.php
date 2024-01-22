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

  // $employee_id_number = htmlspecialchars($_POST['employee_id_number']);
  $employee_id_number = $new_employee_id_number;
  $name = htmlspecialchars($_POST['name']);
  $gender = htmlspecialchars($_POST['gender']);
  $address = htmlspecialchars($_POST['address']);
  $handphone = htmlspecialchars($_POST['handphone']);
  $positions = htmlspecialchars($_POST['positions']);
  $username = htmlspecialchars($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = htmlspecialchars($_POST['role']);
  $status = htmlspecialchars($_POST['status']);
  $presence_location = htmlspecialchars($_POST['presence_location']);

  $rand = rand();
  $ekstensi =  array('png','jpg','jpeg','gif');
  $filename = $_FILES['photo']['name'];
  $ukuran = $_FILES['[photo']['size'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if($ukuran < 1044070){		
		$xx = $rand.'_'.$filename;
		move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/img/photo_employee/'.$rand.'_'.$filename);


  // if (isset($_FILES['photo'])) {
  //   $file = $_FILES['photo'];
  //   $name_file = $file['name'];
  //   $file_tmp = $file['tmp_name'];
  //   $file_size = $file['size'];
  //   $file_directory = '../../assets/img/photo_employee/' . $name_file;
    
    // $take_extension = pathinfo($name_file, PATHINFO_EXTENSION);
    // $extension_permitted = ["jpg","png","jpeg"];
    // $max_file_size = 10 * 1024 * 1024;

    
    // move_uploaded_file($file_tmp, $file_directory);
      
    }
  
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($name)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Name  is mandatory!";
    }
    if (empty($gender)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Gender is mandatory!";
    }
    if (empty($address)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Address loc. is mandatory!";
    }
    if (empty($handphone)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Handphone is mandatory!";
    }
    if (empty($position)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Longitude is mandatory!";
    }
    if (empty($username)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>username is mandatory!";
    }
    if (empty($role)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Role is mandatory!";
    }
    if (empty($status)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Status is mandatory!";
    }
    if (empty($presence_location)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Presence Location is mandatory!";
    }
    if (in_array(strtolower($ext), $ekstensi)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Only JPG, JPEG, and PNG files are allowed";
    }
    
    if (in_array(strtolower($ext), $ekstensi)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Only JPG, JPEG, and PNG files are allowed";
    }


    if (empty($password)) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Password is mandatory!";
    }
    if ($_POST['password'] != $_POST['confirm_password']) {
      $error_message[] = "<i class='fa-solid fa-check'></i>Password does not match!";
    }

    if (!empty($error_message)) {
      $_SESSION['validation'] = implode("<br>", $error_message); // ubah array menjadi string
    } else {
      $employees = mysqli_query($connect, "INSERT INTO employee(employee_id_number, name, gender, 
      address, handphone, positions, presence_location, photo) VALUES 
      ('$employee_id_number', '$name', '$gender', '$address', '$handphone', '$positions', '$presence_location',
      '$xx')");

      $employee_id = mysqli_insert_id($connect);

      $users = mysqli_query($connect, "INSERT INTO users(employee_id, username, password, 
      status, role) VALUES 
      ('$employee_id', '$username', '$password', '$status', '$role')");

      $_SESSION['succeed'] = 'Data saved successfully';
      header("Location: employees.php");
      exit;
    }
  }


// $result = mysqli_query($connect, "SELECT * FROM presence_location ORDER BY id DESC");
?>

<div class="page-body">
  <div class="container-xl">

  <form action="<?= base_url('admin/data_employees/addEmployees.php') ?>" method="POST" enctype="multipart/from-data"> 

    <div class="row">

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
          
          <!--automation add Employee ID Number  -->
          <?php 
          // $take_employee_id_number = mysqli_query($connect, "SELECT employee_id_number FROM employee ORDER BY employee_id_number DESC LIMIT 1");

          // if (mysqli_num_rows($take_employee_id_number) > 0) {
          //   $row = mysqli_fetch_assoc($take_employee_id_number);
          //   $employee_id_number_db = $row['employee_id_number'];
          //   $employee_id_number_db = explode("-", $employee_id_number_db);
          //   $new_number = (int)$employee_id_number_db[1] + 1;
          //   $new_employee_id_number = "EMP-" . str_pad($new_number, 4, 0, STR_PAD_LEFT);
          // } else {
          //   $new_employee_id_number = "EMP-0001";
          // }
          
          ?>    
          
              <!-- <div class="mb-3">
                <label for="">Employee ID Number</label>
                <input type="text" class="form-control" name="employee_id_number" value="<?= $new_employee_id_number ?>" readonly>
              </div> -->

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
                <label for="">Handphone</label>
                <input type="text" class="form-control" name="handphone" value="<?php if (isset($_POST['handphone'])) echo $_POST['handphone'] ?>">
              </div>

              <div class="mb-3">
                <label for="">Position</label>
                <select class="form-control" name="positions">
                  <option value="">--Choose Position--</option>
                  <?php 
                  $take_position = mysqli_query($connect, "SELECT * FROM position ORDER BY positions ASC");

                  while ($position = mysqli_fetch_assoc($take_position)) {
                    $name_position = $position['positions'];

                    if (isset($_POST['positions']) && $_POST['positions'] == $name_position){
                      echo '<option value="'. $name_position .'" selected = "selected">' . $name_position . '</option>';
                    } else {
                      echo '<option value="' . $name_position . '">' . $name_position . '</option>';                
                    }
                  }
                  
                  ?>
                </select> 
              </div>

              <div class="mb-3">
                <label for="">Status</label>
                <select class="form-control" name="status">
                  <option value="">--Choose Status--</option>
                  <option <?php if (isset($_POST['status']) && $_POST['status'] == 'active') { echo 'selected'; } ?> value="active">Active</option>
                  <option <?php if (isset($_POST['status']) && $_POST['status'] == 'nonactive') { echo 'selected'; } ?> value="nonactive">Nonactive</option>
                </select> 

              </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

              <div class="mb-3">
                <label for="">Username</label>
                <input type="text" class="form-control" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>">
              </div>
              
              <div class="mb-3">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password">
              </div>
              
              <div class="mb-3">
                <label for="">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password">
              </div>

              <div class="mb-3">
                <label for="">Role</label>
                <select class="form-control" name="role">
                  <option value="">--Choose Role--</option>
                  <option <?php if (isset($_POST['role']) && $_POST['role'] == 'admin') { echo 'selected'; } ?> value="admin">Admin</option>
                  <option <?php if (isset($_POST['role']) && $_POST['role'] == 'employee') { echo 'selected'; } ?> value="employee">Employee</option>
                </select> 
              </div>

              <div class="mb-3">
                <label for="">Presence Location</label>
                <select class="form-control" name="presence_location">
                  <option value="">--Choose Presence Location--</option>
                  <?php 
                  $take_presence_loc = mysqli_query($connect, "SELECT * FROM presence_location ORDER BY name_location ASC");

                  while ($location = mysqli_fetch_assoc($take_presence_loc)) {
                    $name_loc = $location['name_location'];

                    if (isset($_POST['presence_location']) && $_POST['presence_location'] == $name_loc){
                      echo '<option value="'. $name_loc .'" selected = "selected">' . $name_loc . '</option>';
                    } else {
                      echo '<option value="' . $name_loc . '">' . $name_loc . '</option>';                
                    }
                  }
                  
                  ?>
                </select> 
              </div>

              <div class="mb-3">
                <label for="">Photo</label>
                <input type="file" class="form-control" name="photo">
              </div>

              <button type="submit" class="btn btn-primary" name="save">Save</button>
          
            </div>
        </div>
      </div>

      </form>
    </div>
  </div>
</div>

<?php 
include ('../layout/footer.php')
?>
