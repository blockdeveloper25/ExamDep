<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'admin') {
        include "../DB_connection.php";

        include "data/request.php";
        include "data/exam.php";


        $requests = getallrequests($conn);
        $filterrequests = getReqByStatus($conn);
        $controls = getAllControls($conn);


        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['toggleStatus18'])) {
            $new_status = $_POST['toggleStatus18'] == '0' ? 1 : 0; // Toggle status between 0 and 1
            $sql = "UPDATE formcontrol SET `18` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_status, $_POST['id']]);
            header("Location: examform1.php"); // Refresh page to show updated status
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['toggleStatus19'])) {
            $new_status = $_POST['toggleStatus19'] == '0' ? 1 : 0; // Toggle status between 0 and 1
            $sql = "UPDATE formcontrol SET `19` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_status, $_POST['id']]);
            header("Location: examform1.php"); // Refresh page to show updated status
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['toggleStatus20'])) {
            $new_status = $_POST['toggleStatus20'] == '0' ? 1 : 0; // Toggle status between 0 and 1
            $sql = "UPDATE formcontrol SET `20` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_status, $_POST['id']]);
            header("Location: examform1.php"); // Refresh page to show updated status
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['toggleStatus21'])) {
            $new_status = $_POST['toggleStatus21'] == '0' ? 1 : 0; // Toggle status between 0 and 1
            $sql = "UPDATE formcontrol SET `21` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_status, $_POST['id']]);
            header("Location: examform1.php"); // Refresh page to show updated status
            exit;
        }
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

            if ($controls != 0) {
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
                        <h2>Exam Application Controls</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Faculty</th>
                                    <th>18 Form</th>
                                    <th>19 Form</th>
                                    <th>20 Form</th>
                                    <th>21 Form</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($controls as $control) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($control['id']) ?></td>
                                        <td><?php
                                            if (htmlspecialchars($control['faculty']) == 'FOC') {
                                                echo 'Faculty of Computing';
                                            } elseif (htmlspecialchars($control['faculty']) == 'FOG') {
                                                echo 'Faculty of Geomatics';
                                            } elseif (htmlspecialchars($control['faculty']) == 'FOM') {
                                                echo 'Faculty of Management Studies';
                                            } elseif (htmlspecialchars($control['faculty']) == 'FOS') {
                                                echo 'Faculty of Social Science & Languages';
                                            } elseif (htmlspecialchars($control['faculty']) == 'FOT') {
                                                echo 'Faculty of Technology';
                                            } elseif (htmlspecialchars($control['faculty']) == 'FOA') {
                                                echo 'Faculty of Agriculture';
                                            } elseif (htmlspecialchars($control['faculty']) == 'FAS') {
                                                echo 'Faculty of Applied Science';
                                            }


                                            ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $control['id'] ?>">
                                                <button type="submit" name="toggleStatus18" value="<?= $control['18'] ?>" class="btn <?= $control['18'] == 0 ? 'btn-danger' : 'btn-success' ?>">
                                                    <?= $control['18'] == 0 ? 'Not Active' : 'Active' ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $control['id'] ?>">
                                                <button type="submit" name="toggleStatus19" value="<?= $control['19'] ?>" class="btn <?= $control['19'] == 0 ? 'btn-danger' : 'btn-success' ?>">
                                                    <?= $control['19'] == 0 ? 'Not Active' : 'Active' ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $control['id'] ?>">
                                                <button type="submit" name="toggleStatus20" value="<?= $control['20'] ?>" class="btn <?= $control['20'] == 0 ? 'btn-danger' : 'btn-success' ?>">
                                                    <?= $control['20'] == 0 ? 'Not Active' : 'Active' ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $control['id'] ?>">
                                                <button type="submit" name="toggleStatus21" value="<?= $control['21'] ?>" class="btn <?= $control['21'] == 0 ? 'btn-danger' : 'btn-success' ?>">
                                                    <?= $control['21'] == 0 ? 'Not Active' : 'Active' ?>
                                                </button>
                                            </form>
                                        </td>

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
                        $("#navLinks li:nth-child(8) a").addClass('active');
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