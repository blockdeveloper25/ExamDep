<?php
session_start();
if (
  isset($_SESSION['id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'admin') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "../DB_connection.php";
    include "data/teacher.php";
    include "data/request.php";
    
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin - Home</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="icon" href="../logo.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    </head>

    <body>
      <?php
      include "inc/navbar.php";
      ?>
      <div class="container mt-5">
        <div class="container text-center">
          <div class="col">

          </div>
          <div class="row row-cols-5">
            <a href="teacher.php" class="col btn btn-dark m-2 py-3">
              <i class="fa-solid fa-chalkboard-user fs-1" aria-hidden="true"></i><br>
              Teachers
            </a>
            <a href="student.php" class="col btn btn-dark m-2 py-3">
              <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
              Students
            </a>
            <a href="registrar-office.php" class="col btn btn-dark m-2 py-3">
              <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
              Department Heads
            </a>

            <a href="message.php" class="col btn btn-dark m-2 py-3">
              <i class="fa fa-envelope fs-1" aria-hidden="true"></i><br>
              Message
            </a>
            <a href="course_code.php" class="col btn btn-dark m-2 py-3">
              <i class="fa-solid fa-book-open-reader fs-1" aria-hidden="true"></i><br>
              Course Codes
            </a>
          </div>
          <div class="row row-cols-5">
            <a href="settings.php" class="col btn btn-primary m-2 py-3 col-5">
              <i class="fa fa-cogs fs-1" aria-hidden="true"></i><br>
              Settings
            </a>
            <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
              <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
              Logout
            </a>
          </div>


        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        $(document).ready(function() {
          $("#navLinks li:nth-child(1) a").addClass('active');
        });
      </script>

    </body>

    </html>
<?php

  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}

?>