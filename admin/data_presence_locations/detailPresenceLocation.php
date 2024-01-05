<?php 

session_start();

if (!isset($_SESSION['login'])) {
  header('Location: ../../auth/login.php?message=not_login_yet');
} else  if ($_SESSION['role'] != 'admin') {
  header('Location: ../../auth/login.php?message=deny_access');
}

$title = "Detail Presence Location";

include ('../layout/header.php');

require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connect, "SELECT * FROM presence_location WHERE id=$id");
?>

<?php while($location = mysqli_fetch_array($result)) : ?>

<div class="page-body">
  <div class="container-xl">

  <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Name Location</td>
                        <td>: <?= $location['name_location'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Address Location</td>
                        <td>: <?= $location['address_location'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Type Location</td>
                        <td>: <?= $location['type_location'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Latitude</td>
                        <td>: <?= $location['latitude'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Latitude</td>
                        <td>: <?= $location['longitude'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Radius</td>
                        <td>: <?= $location['radius'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Time Zone</td>
                        <td>: <?= $location['time_zone'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Entry Time</td>
                        <td>: <?= $location['entry_time'] ?></td>
                    </tr>
                    
                    <tr>
                        <td>Out Time</td>
                        <td>: <?= $location['out_time'] ?></td>
                    </tr>

                </table>
            </div>
        </div>
        <a href="<?= base_url('admin/data_presence_locations/presenceLocations.php') ?>" type="submit" class="btn btn-primary mt-2">Back</a>
    </div>
     
  
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.136330299419!2d<?= $location['longitude'] ?>!3d<?= $location['latitude'] ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6993536955c35d%3A0xee6aca1cf6a90fc1!2sCibubur%20Plaza!5e0!3m2!1sen!2sid!4v1704444967821!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    
  </div>
    

  </div>
</div>


<?php endwhile; ?>