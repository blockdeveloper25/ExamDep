<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
  ) {
  
    if ($_SESSION['role'] == 'admin') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/request.php";

        $teachers = getAllTeachers($conn);
        $requests = getallrequests($conn);
        $filterrequests = getReqByStatus($conn);

        

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin - Teachers</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php
            include "inc/navbar.php";
            if ($filterrequests != 0) {
            ?>
                <div class="container mt-5">
                    <h2>Review Approval</h2>

                    <form action="teacher-search.php" class="mt-3 n-table" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="searchKey" placeholder="Search...">
                            <button class="btn btn-primary">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>

                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger mt-3 n-table" role="alert">
                            <?= $_GET['error'] ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-info mt-3 n-table" role="alert">
                            <?= $_GET['success'] ?>
                        </div>
                    <?php } ?>

                    <div class="container mt-5">
                        <h2>Recorrection Requests</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ReqNo</th>
                                    <th>Student RegNo</th>
                                    <th>Payment</th>
                                    <th>Subject Code</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($filterrequests as $request) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($request['req_id']) ?></td>
                                        <td><?= htmlspecialchars($request['username']) ?></td>
                                        <td><a href="<?= htmlspecialchars($request['payment_link']) ?>" target="_blank">View Payment</a></td>
                                        <td><?= htmlspecialchars($request['subject_code']) ?></td>
                                        <td><?= $request['status'] == 1 ? 'Done' : 'Not Done' ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info .w-450 m-5" role="alert">
                        Empty!
                    </div>
                <?php } ?>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#navLinks li:nth-child(5) a").addClass('active');
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