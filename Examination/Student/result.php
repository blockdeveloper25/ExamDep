<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'student') {
        include "../DB_connection.php";
        include "data/student.php";
        include "data/table.php";
        include "data/examform.php";

        $student_id = $_SESSION['id'];

        $student = getStudentById($student_id, $conn);
        
        $conf = $student['confirmation'];
        $conf_message = getNotification($conn, $conf);
        if ($conf_message > 0){
            $mess = $conf_message['message'];
          }
        $reg_no = $student['username'];
        $course = $student['course'];
        $app = $student['confirm'];
        



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
            ?>
            
            <?php
            if ($course == 'SE'){
                include "./SE.php";
            }
            elseif($course == 'IS'){
                include "./IS.php";
            }
            ?>
            <div class="mx-auto" style="width:70%">
                <h4 class="mt-1">Download Results</h4>
                <a href="download.php"><button class="btn btn-primary" style="margin-bottom:20px">Download</button></a>
                <h4 class="mt-1">Apply Recorrection</h4>
                <a href="recorrection.php"><button class="btn btn-primary" style="margin-bottom:20px">Apply </button></a>
            </div>
            
            
            
            
            
            


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