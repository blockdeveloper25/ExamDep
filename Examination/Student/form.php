<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'student') {
        include "../DB_connection.php";
        include "data/student.php";
        include "data/examform.php";

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $student_id = $_SESSION['id'];

        $student = getStudentById($student_id, $conn);
        $sem = $student['confirmation'];
        $mess = getNotification($conn, $sem);
        $fac = $student['faculty'];
        $control = getVisisbilityByFacSem($conn, $fac);
        $batch = $student['batch'];
        $app = $student['ex_conf'];
        $conf = $student['confirmation'];
        
        $conf_message = getNotification($conn, $sem);
        if ($conf_message > 0) {
            $mess = $conf_message['message'];
        }
        $app = $student['confirm'];
        $req = $student['request']; // from users table to control request forms


        $visibility = $control[$batch];

        if (htmlspecialchars($sem) == 0) {
            $semester = 'sem1';
        } elseif (htmlspecialchars($sem) == 1) {
            $semester = 'sem2';
        } elseif (htmlspecialchars($sem) == 2) {
            $semester = 'sem3';
        } elseif (htmlspecialchars($sem) == 3) {
            $semester = 'sem4';
        } elseif (htmlspecialchars($sem) == 4) {
            $semester = 'sem5';
        } elseif (htmlspecialchars($sem) == 5) {
            $semester = 'sem6';
        } elseif (htmlspecialchars($sem) == 6) {
            $semester = 'sem7';
        } elseif (htmlspecialchars($sem) == 7) {
            $semester = 'sem8';
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $semester = $_POST['semester'];
            $subjectCode = $_POST['subjectCode'];
            $userId = $student_id; // Assume this is dynamically determined or retrieved from session

            // SQL query to update the user's data
            $sql = "UPDATE users SET $semester = ?, request = 1 WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$subjectCode, $userId]);


            // Set a session message to display after the redirect
            $_SESSION['message'] = "Details updated successfully!";

            // Redirect to the same page to avoid form resubmission on refresh
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
        unset($_SESSION['message']);
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student - Home</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php include "inc/navbar.php";
            if ($visibility == 1) {
                if ($req == 0 && $app == 0 ) { ?>
                    <div class="container mt-5 shadow p-3 my-5 form-w">
                        <h2>Exam Application</h2>
                        <form action="form.php" method="post">
                            <div class="mb-3">

                                <?php
                                if (htmlspecialchars($sem) == 0) {
                                    echo 'Semester 1';
                                } elseif (htmlspecialchars($sem) == 1) {
                                    echo 'Semester 2';
                                } elseif (htmlspecialchars($sem) == 2) {
                                    echo 'Semester 3';
                                } elseif (htmlspecialchars($sem) == 3) {
                                    echo 'Semester 4';
                                } elseif (htmlspecialchars($sem) == 4) {
                                    echo 'Semester 5';
                                } elseif (htmlspecialchars($sem) == 5) {
                                    echo 'Semester 6';
                                } elseif (htmlspecialchars($sem) == 6) {
                                    echo 'Semester 7';
                                } elseif (htmlspecialchars($sem) == 7) {
                                    echo 'Semester 8';
                                }


                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="subjectCode" class="form-label">Subject Code:</label>
                                <textarea class="form-control" id="subjectCode" name="subjectCode" placeholder="SE1101,SE1102.." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <?php if (!empty($message)) {
                            echo "<div class='alert alert-success'>$message</div>";
                        } ?>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info .w-450 m-5"
                        role="alert">
                        You have already filled your form
                    </div>
                <?php }
            } else { ?>
                <div class="alert alert-info .w-450 m-5"
                    role="alert">
                    Empty!
                </div>
            <?php } ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(3) a").addClass('active');
                });
                setTimeout(function() {
                    let alerts = document.querySelectorAll('.alert-succes');
                    if (alerts) {
                        alerts.forEach(function(alert) {
                            alert.style.display = 'none';
                        });
                    }
                }, 5000);
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
        header("Location: ../../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>