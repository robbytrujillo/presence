<?php

session_start();

require_once('../config.php');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = mysqli_query($connect, "SELECT * FROM users JOIN employee ON users.employee_id = employee.id WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
      if ($row['status'] == 'active') {

          $_SESSION["login"] = true;
          $_SESSION["id"] = $row["id"];
          $_SESSION["role"] = $row["role"];
          $_SESSION["name"] = $row["name"];
          $_SESSION["employee_id_number"] = $row["employee_id_number"];
          $_SESSION["position"] = $row["position"];
          $_SESSION["presence_location"] = $row["presence_location"];

          if ($row['role'] === 'admin') {
            header("Location: ../admin/home/home.php");
            exit();
          } else {
            header("Location: ../employee/home/home.php");
            exit();
          }

      } else {
        $_SESSION["fail"] = "Your account is not active yet";
      }
    } else {
      $_SESSION["fail"] = "Incorrect password, please try again";
    }
  } else {
    $_SESSION["fail"] = "Incorrect username, please try again";
  }
}

?>

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in with illustration - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="<?= base_url('assets/css/tabler.min.css?1684106062" rel="stylesheet') ?>"/>
    <link href="<?= base_url('assets/css/tabler-vendors.min.css?1684106062') ?>" rel="stylesheet"/>
    <link href="<?= base_url('assets/css/demo.min.css?1684106062') ?>" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url('assets/img/pres-remove.png') ?>" height="36" alt=""></a>
              </div>

              <?php 

              if (isset($_GET['message'])) {
                 if ($_GET['message'] == 'not_login_yet') {
                      $_SESSION['fail'] = 'You are not login yet';
                 } else if ($_GET['message'] == 'deny_access') {
                      $_SESSION['fail'] = 'Access to this page is denied';
                 }
              }

              ?>

              <!-- <?= password_hash('123', PASSWORD_DEFAULT); ?> -->

              <div class="card card-md">
                <div class="card-body">
                  <h2 class="h2 text-center mb-4">Login to your account</h2>
                  <form action="" method="post" autocomplete="off" novalidate>
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" autofocus class="form-control" name="username" placeholder="Your username" autocomplete="off">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">
                        Password
                        <!-- <span class="form-label-description">
                          <a href="./forgot-password.html">I forgot password</a>
                        </span> -->
                      </label>
                      <div class="input-group input-group-flat">
                        <input type="password" class="form-control" name="password" placeholder="Your password"  autocomplete="off">
                        <span class="input-group-text">
                          <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                          </a>
                        </span>
                      </div>
                    </div>
                    <!-- <div class="mb-2">
                      <label class="form-check">
                        <input type="checkbox" class="form-check-input"/>
                        <span class="form-check-label">Remember me on this device</span>
                      </label>
                    </div> -->
                    <div class="form-footer">
                      <button type="submit" name="login" class="btn btn-primary w-100">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src="<?= base_url('assets/img/undraw_access_account_re_8spm.svg') ?>" height="300" class="d-block mx-auto" alt="">
          </div>
        </div>
      </div>
    </div>
    <script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js?1684106062') ?>" defer></script>
    <script src="<?= base_url('assets/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062') ?>" defer></script>
    <script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world.js?1684106062') ?>" defer></script>
    <script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world-merc.js?1684106062') ?>" defer></script>
    <!-- Tabler Core -->
    <script src="<?= base_url('assets/js/tabler.min.js?1684106062') ?>" defer></script>
    <script src="<?= base_url('assets/js/demo.min.js?1684106062') ?>" defer></script>
    
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Sweet Alert Check -->
    <?php if ($_SESSION['fail']) {?>
    <script>
      Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "<?= $_SESSION['fail'] ?>",
      });
    </script>

    <?php unset($_SESSION['fail']); ?>

    <?php } ?>
    
    <!-- <script>
        Swal.fire("SweetAlert2 is working!");
    </script> -->

</body>
</html>