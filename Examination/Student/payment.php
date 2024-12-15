<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {
    if ($_SESSION['role'] == 'student') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/student.php";
        include "data/examform.php";


        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $student_id = $_SESSION['id'];

        // Fetch student details from the database
        $student = getStudentById($student_id, $conn);
        $fname = $student['fname'];
        $lname = $student['lname'];
        $city = $student['address'];
        $phone = $student['phone_number'];
        $email = $student['email_address'];

        $fac = $student['faculty'];

        $conf = $student['confirmation'];
        $conf_message = getNotification($conn, $conf);
        if ($conf_message > 0) {
            $mess = $conf_message['message'];
        }
        $app = $student['confirm'];

        // Check for any notifications from the session
        $notificationMessage = isset($_SESSION['notification_message']) ? $_SESSION['notification_message'] : '';
        unset($_SESSION['notification_message']); // Clear message after using it
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student - Payment</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php include "inc/navbar.php";

            ?>
            <div class="container mt-5 shadow p-3 my-5 form-w">
                <h1>Semester Payment </h1>

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="buynow(<?php echo $student_id; ?>)">
                    Pay now
                </button>
            </div>



            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="./payment.js"></script>
            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(5) a").addClass('active');
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