<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
  ) {
  
    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/table.php";

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $teacher_id = $_SESSION['id'];
        $teacher = getTeacherById($teacher_id, $conn);
        $subjectCode = $_SESSION['subjectCode'];
        $data = fetchTableData($conn, $subjectCode);



        if ($data === null) {
            echo "<div class='alert alert-danger'>Error: The table for '$subjectCode' does not exist.</div>";
            echo "<a href='displaymarks.php'><button class='btn btn-primary'>Go Back to Home</button></a>";
            exit;
        }


?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Teachers - Students</title>
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
            <div class="container mt-5">
            <h2>Marks for <?= htmlspecialchars($subjectCode) ?></h2>
                <div class='table-responsive'>
                <table class="table table-bordered mt-3 n-table">
                    <tr>
                        <th scope="col">Reg No</th>
                        <th scope="col">Marks</th>
                    </tr>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['reg_no']) ?></td>
                            <td><?= htmlspecialchars($row['marks']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                </div>
                
                
                <a href="displaymarks.php"><button class="btn btn-primary">Go Back to Home</button></a>
            </div>






        </html>
        <script>
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert');
                if (alerts) {
                    alerts.forEach(function(alert) {
                        alert.style.display = 'none';
                    });
                }
            }, 5000);
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#navLinks li:nth-child(2) a").addClass('active');
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