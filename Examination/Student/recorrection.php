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
        $conf_message = getNotification($conn, $conf);
        if ($conf_message > 0){
            $mess = $conf_message['message'];
          }
        $app = $student['confirm'];


        $course = $student['course'];
        $batch = $student['batch'];
        $teachers = getTeacherByCourse($course, $conn);


        // Fetch and display each table name


        function extractLettersFromCourseCode($courseCode)
        {
            // Use regular expression to find all alphabetic characters
            preg_match_all('/[A-Za-z]+/', $courseCode, $matches);

            // Check if there are any matches and return the first match found
            if (!empty($matches[0])) {
                return $matches[0][0]; // Returns the concatenated string of all matches
            } else {
                return ""; // Return an empty string if no alphabetic characters are found
            }
        }

        // Function to filter modules based on the selected prefix
        function filterModulesByPrefix($modules, $selectedPrefix)
        {
            $filteredModules = [];
            foreach ($modules as $module) {
                // Extract the first two letters of the module code
                $prefix = extractLettersFromCourseCode($module);
                if ($prefix === $selectedPrefix) {
                    $filteredModules[] = $module;
                }
            }
            return $filteredModules;
        }
        $teacher_names = [];
        foreach ($teachers as $teacher) {
            $teach_id = $teacher['user_id'];
            $teacher_names[] = getTeacherById($teach_id, $conn);
        }

        // Check if the form has been submitted
        $selectedPrefix = $student['course'];
        $allModules = getAllTableNames($conn);
        $filteredModules = filterModulesByPrefix($allModules, $selectedPrefix);
        // Now you can use $filteredModules for further operations, like displaying them or processing further
        $foundTables = findTablesByBatchValue($filteredModules, $conn, $batch);

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Assume $student['username'] is stored in the session
            $username = $student['username']; // Adjust according to your session structure
            $paymentLink = $_POST['payment_link'];
            $subjectCode = $_POST['subject_code'];
            $teacher_name = $_POST['teacher_name'];

            try {
                // Prepare an INSERT statement
                $sql = "INSERT INTO recorrection (username,teacher_name, payment_link, subject_code,course,batch, approved) VALUES (?, ?, ?, ?,?,? ,0)";
                $stmt = $conn->prepare($sql);

                // Bind parameters and execute
                $stmt->bindParam(1, $username);
                $stmt->bindParam(2, $teacher_name);
                $stmt->bindParam(3, $paymentLink);
                $stmt->bindParam(4, $subjectCode);
                $stmt->bindParam(5, $course);
                $stmt->bindParam(6, $batch);
                $stmt->execute();

                // Show a success message
                $successMsg = "Recorrection request submitted successfully.";
            } catch (PDOException $e) {
                // Show an error message if something goes wrong
                $errorMsg = "Error submitting the recorrection request: " . $e->getMessage();
            }
        }
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



            <body>
                <div class="container mt-5 shadow p-3 my-5 form-w">
                    <h1 class="mb-3">Recorrection Request Form</h1>

                    <!-- Display success or error message -->
                    <?php if (!empty($successMsg)) : ?>
                        <div class="alert alert-success"><?= $successMsg; ?></div>
                    <?php elseif (!empty($errorMsg)) : ?>
                        <div class="alert alert-danger"><?= $errorMsg; ?></div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="form-group mb-2">
                            <label for="payment_link">Payment Link:</label>
                            <input type="text" id="payment_link" name="payment_link" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="subject_code">Subject Code:</label>
                            <select id="subject_code" name="subject_code" class="form-control" required>
                                <option value="" disabled selected>Choose the Course Module</option>
                                <?php foreach ($foundTables as $module) : ?>
                                    <option value="<?= htmlspecialchars($module); ?>"><?= htmlspecialchars($module); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>



                        <div class="form-group mb-2">
                            <label for="teacher_name">Teacher Name:</label>
                            <select id="teacher_name" name="teacher_name" class="form-control" required>
                                <option value="" disabled selected>Choose the Teacher</option>
                                <?php foreach ($teacher_names as $teacher_name) : ?>
                                    <option value="<?= htmlspecialchars($teacher_name[0]); ?>"><?= htmlspecialchars($teacher_name[0]); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </form>
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