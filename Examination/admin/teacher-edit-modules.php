<?php

session_start();

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role']) &&
    isset($_GET['teacher_id'])
) {

    if ($_SESSION['role'] == 'admin') {

        include "../DB_connection.php";
        include "data/teacher.php";

        $teacher_id = $_GET['teacher_id'];
        $teacher = getTeacherById($teacher_id, $conn);

        if ($teacher == 0) {
            header("Location: teacher.php");
            exit;
        }

        // Function to insert or update lecture modules
        function upsertLectureModule($teacher_id, $course, $batch18, $batch19, $batch20, $batch21, $batch22, $conn)
        {
            // Check if the user_id already exists in the lecturemodules table
            $sql_check = "SELECT COUNT(*) FROM lecturemodules WHERE user_id = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->execute([$teacher_id]);
            $count = $stmt_check->fetchColumn();

            // If user_id exists, update the row
            if ($count > 0) {
                $sql_update = "UPDATE lecturemodules SET course = ?, `18` = ?, `19` = ?, `20` = ?, `21` = ?, `22` = ? WHERE user_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                return $stmt_update->execute([$course, $batch18, $batch19, $batch20, $batch21, $batch22, $teacher_id]);
            } 
            // If user_id does not exist, insert a new row
            else {
                $sql_insert = "INSERT INTO lecturemodules (user_id, course, `18`, `19`, `20`, `21`, `22`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                return $stmt_insert->execute([$teacher_id, $course, $batch18, $batch19, $batch20, $batch21, $batch22]);
            }
        }

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin - Edit Teacher</title>
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

            <div class="container">
                <h2 class="mt-5">Add Lecture Module</h2>
                <a href="teacher.php"><button class="btn btn-primary mt-3">Go Back to Home</button></a>
                <form action="" method="POST" class="container mt-5 shadow p-3 my-5 form-w">
                    <div class="form-group">
                        <label for="course">Course</label>
                        <select class="form-control" id="course" name="course" required>
                            <?php
                            $courses = explode(',', $teacher['course']);
                            foreach ($courses as $course) {
                                $course = trim($course); // Trim whitespace
                                echo "<option value='" . htmlspecialchars($course) . "'>" . htmlspecialchars($course) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="batch18">Batch 18</label>
                        <input type="text" class="form-control" id="batch18" name="batch18">
                    </div>
                    <div class="form-group">
                        <label for="batch19">Batch 19</label>
                        <input type="text" class="form-control" id="batch19" name="batch19">
                    </div>
                    <div class="form-group">
                        <label for="batch20">Batch 20</label>
                        <input type="text" class="form-control" id="batch20" name="batch20">
                    </div>
                    <div class="form-group">
                        <label for="batch21">Batch 21</label>
                        <input type="text" class="form-control" id="batch21" name="batch21">
                    </div>
                    <div class="form-group">
                        <label for="batch22">Batch 22</label>
                        <input type="text" class="form-control" id="batch22" name="batch22">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    
                </form>
               
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include '../DB_connection.php'; // Your database connection file

                // Get form data
                $course = $_POST['course'];
                $batch18 = !empty($_POST['batch18']) ? $_POST['batch18'] : null;
                $batch19 = !empty($_POST['batch19']) ? $_POST['batch19'] : null;
                $batch20 = !empty($_POST['batch20']) ? $_POST['batch20'] : null;
                $batch21 = !empty($_POST['batch21']) ? $_POST['batch21'] : null;
                $batch22 = !empty($_POST['batch22']) ? $_POST['batch22'] : null;

                // Check if form is valid
                if (empty($course) || empty($batch18) && empty($batch19) && empty($batch20) && empty($batch21) && empty($batch22)) {
                    echo "<div class='alert alert-danger mt-3'>Please fill in all required fields.</div>";
                } else {
                    // Call upsertLectureModule function to insert or update
                    $result = upsertLectureModule($teacher_id, $course, $batch18, $batch19, $batch20, $batch21, $batch22, $conn);

                    if ($result) {
                        $_SESSION['alert_success'] = "Record created/updated successfully";
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?teacher_id=' . urlencode($teacher_id));
                        exit;
                    } else {
                        $_SESSION['alert_error'] = "Error executing statement";
                    }
                }
            }

            // Success or Error alert handling
            if (isset($_SESSION['alert_success'])) {
                echo "<div class='alert alert-success container mt-5 shadow p-3 my-5 form-w'>{$_SESSION['alert_success']}</div>";
               
                unset($_SESSION['alert_success']); // Clear the session alert message
            }

            if (isset($_SESSION['alert_error'])) {
                echo "<div class='alert alert-danger container mt-5 shadow p-3 my-5 form-w'>{$_SESSION['alert_error']}</div>";
                unset($_SESSION['alert_error']); // Clear the session alert message
            }
            ?>
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
        header("Location: teacher.php");
        exit;
    }
} else {
    header("Location: teacher.php");
    exit;
}
ob_end_flush();
