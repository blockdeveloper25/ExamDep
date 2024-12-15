<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
        include "../DB_connection.php"; // Your database connection

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Step 1: Process the attendance submission via AJAX
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
            $response = ['success' => false, 'message' => 'Failed to update attendance.'];

            if (isset($_POST['username'], $_POST['semester'], $_POST['subject_count'], $_POST['attended_lectures'], $_POST['total_lectures'])) {
                $username = $_POST['username'];
                $semester = $_POST['semester'];
                $subject_count = (int)$_POST['subject_count'];

                $total_attendance = 0;

                for ($i = 0; $i < $subject_count; $i++) {
                    $attended = (int)$_POST['attended_lectures'][$i];
                    $total = (int)$_POST['total_lectures'][$i];

                    if ($total > 0) {
                        $attendance_percentage = ($attended / $total) * 100;
                        $total_attendance += $attendance_percentage;
                    }
                }

                // Calculate the overall average attendance
                $overall_attendance = $total_attendance / $subject_count;

                // Save to the correct semester's attendance column (oa_sem1 to oa_sem8)
                $attendance_column = 'oa_' . $semester;
                $sql = "UPDATE users SET $attendance_column = ? WHERE username = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute([$overall_attendance, $username])) {
                    $response['success'] = true;
                    $response['message'] = "Attendance successfully updated for $username in $semester.";
                }
            }

            echo json_encode($response);
            exit;
        }
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student Attendance</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php include "inc/navbar.php"; ?>

            <div class="container mt-5">
                <h2>Calculate Overall Attendance</h2>
                <form id="attendanceForm">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Semester</label>
                        <select name="semester" class="form-select" required>
                            <option value="sem1">Semester 1</option>
                            <option value="sem2">Semester 2</option>
                            <option value="sem3">Semester 3</option>
                            <option value="sem4">Semester 4</option>
                            <option value="sem5">Semester 5</option>
                            <option value="sem6">Semester 6</option>
                            <option value="sem7">Semester 7</option>
                            <option value="sem8">Semester 8</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Number of Subjects</label>
                        <input type="number" name="subject_count" id="subject_count" class="form-control" required min="1">
                    </div>
                    <div id="subjectFields"></div>
                    <button type="button" id="generateFields" class="btn btn-secondary">Generate Fields</button>
                    <button type="button" id="calculateAttendance" class="btn btn-primary mr-3">Calculate Attendance</button>
                </form>
            </div>

            <!-- Bootstrap Toast -->
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                    <div class="toast-header">
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-success" id="toastMessage">
                        <!-- Message will be injected here -->
                    </div>
                </div>
                <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                    <div class="toast-header">
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-danger" id="errorToastMessage">
                        <!-- Error message will be injected here -->
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // Dynamically generate fields based on subject count
                $('#generateFields').on('click', function() {
                    var subjectCount = $('#subject_count').val();
                    var subjectFields = $('#subjectFields');
                    subjectFields.empty(); // Clear existing fields

                    for (var i = 1; i <= subjectCount; i++) {
                        subjectFields.append(`
                    <div class="mb-3">
                        <label>Subject ` + i + ` - Attended Lectures</label>
                        <input type="number" name="attended_lectures[]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Subject ` + i + ` - Total Lectures</label>
                        <input type="number" name="total_lectures[]" class="form-control" required>
                    </div>
                `);
                    }
                });

                // Submit form using AJAX with validation
                $('#calculateAttendance').on('click', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    let isValid = true; // To track validation status
                    let formData = $('#attendanceForm').serializeArray();
                    formData.push({
                        name: 'ajax',
                        value: 'true'
                    });

                    // Check if any "Attended Lectures" or "Total Lectures" fields are empty
                    $('input[name="attended_lectures[]"], input[name="total_lectures[]"]').each(function() {
                        if ($(this).val() === '') {
                            isValid = false; // Mark form as invalid
                            $(this).addClass('is-invalid'); // Add Bootstrap 'is-invalid' class for visual feedback
                        } else {
                            $(this).removeClass('is-invalid'); // Remove 'is-invalid' class if field is filled
                        }
                    });

                    // If all fields are valid, proceed with AJAX submission
                    if (isValid) {
                        $.ajax({
                            url: '', // Current PHP file
                            method: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    // Show the toast message
                                    $('#toastMessage').text(response.message);
                                    var toast = new bootstrap.Toast(document.getElementById('successToast'));
                                    toast.show();

                                    // Clear the form fields
                                    $('#attendanceForm')[0].reset();
                                    $('#subjectFields').empty(); // Clear dynamically generated subject fields
                                } else {
                                    // Show error message
                                    $('#errorToastMessage').text(response.message);
                                    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                                    errorToast.show();
                                }
                            }
                        });
                    } else {
                        // Show an error toast if validation fails
                        $('#errorToastMessage').text("Please fill in all fields before submitting.");
                        var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                        errorToast.show();
                    }
                });
            </script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(10) a").addClass('active');
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