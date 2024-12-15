<?php


session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'student') {
        include "../DB_connection.php";
        include "data/student.php";
        include "data/table.php";
        include "data/teacher.php";
        include "data/examform.php";

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $student_id = $_SESSION['id'];

        $student = getStudentById($student_id, $conn);
        $conf = $student['confirmation'];
        if ($conf_message > 0){
            $mess = $conf_message['message'];
          }
        $app = $student['confirm'];


        $course = $student['course'];
        $batch = $student['batch'];
        $teachers = getTeacherByCourse($course, $conn);
       


?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student - Grade Summary</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php
            include "inc/navbar.php";
            if ($conf == 1) {
                echo "Exam Application Confirmed";
            }
            ?>



            <body>
                <div>

                </div>

                <!-- Include Bootstrap JS and Popper.js -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            </body>

        </html>









        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#navLinks li:nth-child(2) a").addClass('active');
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
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}

?>