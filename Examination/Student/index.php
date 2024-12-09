<?php
session_start();
if (
  isset($_SESSION['id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'student') {
    include "../DB_connection.php";
    include "data/student.php";
    include "data/examform.php";


    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $student_id = $_SESSION['id'];

    $student = getStudentById($student_id, $conn);
    $conf = $student['confirmation'];
    $conf_message = getNotification($conn, $conf);
    if ($conf_message > 0){
      $mess = $conf_message['message'];
    }
    
    $app = $student['confirm'];

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Student - Home</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="icon" href="../logo.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
      <?php
      include "inc/navbar.php";
      ?>
      <?php
      if ($student != 0) {
      ?>
        <div class="container mt-5">
          <div class="card" style="width: 22rem;">
            <img src="../img/student-<?= $student['gender'] ?>.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title text-center">@<?= $student['username'] ?></h5>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">First name: <?= $student['fname'] ?></li>
              <li class="list-group-item">Last name: <?= $student['lname'] ?></li>
              <li class="list-group-item">Username: <?= $student['username'] ?></li>
              <li class="list-group-item">Course:
                <?php
                if ($student['course'] == 'SE') {
                  echo 'Software Engineering';
                } else if ($student['course'] == 'IS') {
                  echo 'Information Systems ';
                }
                ?></li>
              <li class="list-group-item">Address: <?= $student['address'] ?></li>
              <li class="list-group-item">Date of birth: <?= $student['date_of_birth'] ?></li>
              <li class="list-group-item">Email address: <?= $student['email_address'] ?></li>
              <li class="list-group-item">Gender: <?= $student['gender'] ?></li>
              <li class="list-group-item">Date of joined: <?= $student['date_of_joined'] ?></li>


              <li class="list-group-item">Parent first name: <?= $student['parent_fname'] ?></li>
              <li class="list-group-item">Parent last name: <?= $student['parent_lname'] ?></li>
              <li class="list-group-item">Parent phone number: <?= $student['parent_phone_number'] ?></li>
            </ul>
          </div>
        </div>

      <?php
      } else {
        header("Location: student.php");
        exit;
      }
      ?>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        $(document).ready(function() {
          $("#navLinks li:nth-child(1) a").addClass('active');
        });
      </script>
      <script>
        // Function to hide the notification badge
        function hideBadge() {
          var badge = document.getElementById('notificationBadge');
          if (badge) {
            badge.style.display = 'none'; // Hide the badge
          }
        }
      </script>
    </body>

    </html>
<?php

  } else {
    header("Location: ../../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}

?>