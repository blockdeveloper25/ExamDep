<?php

session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/recorrect.php";
        error_reporting(E_ALL);
        ini_set('display_errors', 1);


        $teacher_id = $_SESSION['id'];
        $teacher = getTeacherById($teacher_id, $conn);
        $username = $teacher['username'];
        $requests = getALLRecorrectReq($conn, $username);



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

            if ($requests != 0) {
            ?>
                <div class="container mt-5">
                    <h2>Your Recorrection Requests</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student Username</th>
                                <th>Subject Code</th>
                                <th>Course</th>
                                <th>Batch</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request) {
                                if ($request['status'] == 1) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($request['username']) ?></td>
                                        <td><?= htmlspecialchars($request['subject_code']) ?></td>
                                        <td><?= htmlspecialchars($request['course']) ?></td>
                                        <td><?= htmlspecialchars($request['batch']) ?></td>
                                        <td>
                                            <?= $request['status'] == 1 ? 'Done' : 'Undone' ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            <?php
            } else {
                echo "Error";
            }
            ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(6) a").addClass('active');
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