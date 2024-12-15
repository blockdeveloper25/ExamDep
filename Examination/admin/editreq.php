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

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $req_id = $_POST['req_id'];
                $approved = $_POST['approved'];
                $sql = "UPDATE recorrection SET approved = ? WHERE req_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$approved, $req_id]);
                echo "<div class='container my-auto shadow p-3 form-w'>";
                echo "<p>Update successful.</p> <a href='recorrect_req.php'><button type='submit' class='btn btn-success mt-2'>Back to Table</button></a>";
                echo "</div>";
                exit;
            } catch (Exception $e) {
                $req_id = $_POST['req_id'];
                $request = getReqByID($conn, $req_id);

                if (!$request) {
                    echo 'Error: ' . $e->getMessage();
                }
            }
        }
        $req_id = $_GET['req_id'];
        $request = getReqByID($conn, $req_id);

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
            if ($teachers != 0) {
            ?>
                <div class="container mt-5">
                    



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
                        <h2>Edit Recorrection Request</h2>
                        <form action="editreq.php" method="post">
                            <div class="form-group">
                                <label for="approved">Approved Status:</label>
                                <select id="approved" name="approved" class="form-control">
                                    <option value="0" <?= $request['approved'] == 0 ? 'selected' : '' ?>>Not Approved</option>
                                    <option value="1" <?= $request['approved'] == 1 ? 'selected' : '' ?>>Approved</option>
                                </select>
                            </div>
                            <input type="hidden" name="req_id" value="<?= $req_id ?>">
                            <button type="submit" class="btn btn-success mt-2">OK</button>
                            
                        </form>
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