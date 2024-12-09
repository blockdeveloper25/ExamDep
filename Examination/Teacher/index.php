<?php

session_start();
if (
  isset($_SESSION['id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'teacher') {
    include "../DB_connection.php";
    include "data/teacher.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $teacher_id = $_SESSION['id'];
    $teacher = getTeacherById($teacher_id, $conn);



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Teacher - Home</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="icon" href="../logo.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
      <?php
      include "inc/navbar.php";

      if ($teacher != 0) {
      ?>
        <div class="container mt-5 d-flex flex-row ">
          <div class="card" style="width: 22rem;">
            <img src="../img/teacher-<?= $teacher['gender'] ?>.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title text-center">@<?= $teacher['username'] ?></h5>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">First name: <?= $teacher['fname'] ?></li>
              <li class="list-group-item">Last name: <?= $teacher['lname'] ?></li>
              <li class="list-group-item">Username: <?= $teacher['username'] ?></li>
              <li class="list-group-item">Courses <?= $teacher['course'] ?></li>
              <li class="list-group-item">Employee number: <?= $teacher['employee_number'] ?></li>
              <li class="list-group-item">Address: <?= $teacher['address'] ?></li>
              <li class="list-group-item">Date of birth: <?= $teacher['date_of_birth'] ?></li>
              <li class="list-group-item">Phone number: <?= $teacher['phone_number'] ?></li>
              <li class="list-group-item">Qualification: <?= $teacher['qualification'] ?></li>
              <li class="list-group-item">Email address: <?= $teacher['email_address'] ?></li>
              <li class="list-group-item">Gender: <?= $teacher['gender'] ?></li>
              <li class="list-group-item">Date of joined: <?= $teacher['date_of_joined'] ?></li>


            </ul>

          </div>
          <div class="ms-5 table-responsive">
            <?php
            $allcourses = explode(',', $teacher['course']);
            foreach ($allcourses as $course) {
              $module = getLectureModulesById($teacher_id, $conn, $course);
              if (is_array($module) && isset($module['course'])) { ?>
                <h1>Teaching <?= $module['course'] ?> Modules</h1>
                <div >
                  <table class="table table-bordered mt-3 n-table">
                    <thead>
                      <tr>


                        <th scope="col">18/19 Batch</th>
                        <th scope="col">19/20 Batch</th>
                        <th scope="col">20/21 Batch</th>
                        <th scope="col">21/22 Batch</th>
                        <th scope="col">22/23 Batch</th>


                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>
                          <?= $module['18'] ?>
                        </td>

                        <td><?= $module['19'] ?></td>
                        <td><?= $module['20'] ?></td>
                        <td><?= $module['21'] ?></td>
                        <td><?= $module['22'] ?></td>

                      </tr>

                    </tbody>
                  </table>
                </div>
              <?php } ?>
            <?php } ?>
          </div>

        </div>

        </div>

      <?php
      } else {
        header("Location: logout.php?error=An error occurred");
        exit;
      }
      ?>

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