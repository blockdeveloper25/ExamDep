<?php
ob_start();
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/marks.php";

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $teacher_id = $_SESSION['id'];
        $teacher = getTeacherById($teacher_id, $conn);
        $courses = $teacher['course'];
        $lectcourses = explode(',', $courses);





        // Function to filter modules based on the selected prefix


        // Check if the form has been submitted
        $alertMessage = '';
        if (isset($_POST['course']) && isset($_POST['batch'])) {
            $_SESSION['course'] = $_POST['course'];
            $_SESSION['batch'] = $_POST['batch'];
            $selectedModules = [];
            $allModules = getAllModules($conn, $_SESSION['course'], $teacher_id);

            if ($allModules != NULL && isset($allModules[$_SESSION['batch']])) {
                $Modules = $allModules[$_SESSION['batch']];
                if ($Modules != NULL) {
                    $selectedModules = explode(',', $Modules);
                } else {
                    $alertMessage = "<div class='alert alert-danger'>No Subject Codes are Taught for this batch</div>";
                }
            } else {
                $alertMessage = "<div class='alert alert-danger'>No Subject Codes are Taught for this batch</div>";
            }
        }




        // Function to check if a table exists
        function tableExists($conn, $tableName)
        {
            try {
                $result = $conn->query("SELECT 1 FROM $tableName LIMIT 1");
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        if (isset($_POST['add'])) {
            $module = $_POST['subject_code'];
            if (tableExists($conn, $module)) {


                // Check if the batch already exists in the module table
                if (checkBatchExists($conn, $module, $_SESSION['batch'])) {
                    $alertMessage =  "<div class='alert alert-danger'>Batch details have already been added to the module.</div>";
                } else {
                    header("Location: insertUsers.php?module=$module&batch=" . $_SESSION['batch']);
                    exit;
                }
            } else {
                $alertMessage = "<div class='alert alert-danger'>There is no Table exists</div>";
            }
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

            <div class="p-3">
                <div class="container mt-5 shadow p-3 my-5 form-w">
                    <h1> Add marks</h1>
                    <form method="post">
                        <div class="mb-3">
                            <label for="course" class="form-label mb-2">Select Course</label>
                            <select name="course" id="course" class="form-control" required>
                                <?php if (!empty($lectcourses)) : ?>
                                    <?php foreach ($lectcourses as $course) : ?>

                                        <option value="<?= htmlspecialchars(trim($course)) ?>"><?= htmlspecialchars(trim($course)) ?></option>

                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <!-- Display a disabled placeholder if no codes are available -->
                                    <option disabled selected>No available codes</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="batch" class="form-label mb-2">Select Course</label>
                            <select name="batch" id="batch" class="form-control" required>
                                <option value="18">18/19 Batch</option>
                                <option value="19">19/20 Batch</option>
                                <option value="20">20/21 Batch</option>
                                <option value="21">21/22 Batch</option>
                                <option value="22">22/23 Batch</option>

                            </select>
                        </div>
                        <button name="ok" type="submit" class="btn btn-success">OK</button>
                    </form>

                    <form action="marks.php" method="post">
                        <div class="mb-3 mt-4">
                            <label for="subject_code" class="form-label">Subject Code:</label>
                            <select id="subject_code" name="subject_code" class="form-control" required>
                                <?php if (!empty($selectedModules)) : ?>
                                    <?php foreach ($selectedModules as $code) : ?>
                                        <?php if (!empty($code)) : // Check if code is not empty 
                                        ?>
                                            <option value="<?= htmlspecialchars(trim($code)) ?>"><?= htmlspecialchars(trim($code)) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <!-- Display a disabled placeholder if no codes are available -->
                                    <option disabled selected>No available codes</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" name="add" class="btn btn-success">Add Marks</button>
                        <!-- Display alert message -->
                        <?php if (!empty($alertMessage)) : ?>
                            <?= $alertMessage ?>
                        <?php endif; ?>
                        <h4 class="mt-3"> Create Table</h4>
                        <p class="fw-medium">To add Marks you want to create Module table First</p>
                        <a href="addmarks.php" class='btn btn-primary'>Create Table</a>
                    </form>

                </div>
            </div>




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
                    $("#navLinks li:nth-child(3) a").addClass('active');
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
ob_end_flush();
?>