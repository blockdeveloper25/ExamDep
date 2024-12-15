<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'student') {
        // Directory where the timetables are stored
        include "../DB_connection.php"; // Ensure this path is correct
        include "data/examform.php";
        include "data/student.php";
        $student_id = $_SESSION['id'];

        $student = getStudentById($student_id, $conn);
        $conf = $student['confirmation'];
        $mess = getNotification($conn, $conf);
        $directory = "../admin/timetables/";
        $conf = $student['confirmation'];
        $conf_message = getNotification($conn, $conf);
        if ($conf_message > 0){
            $mess = $conf_message['message'];
          }
        $app = $student['confirm'];

        // Scan the directory and list all PDF files
        $files = array_diff(scandir($directory), array('..', '.'));
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student - Change Password</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php include "inc/navbar.php"; ?>

            <div class="container mt-5">
                <h1>Download Timetable PDFs</h1>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if there are any files
                        if (count($files) > 0) {
                            // Loop through each file
                            foreach ($files as $file) {
                                // Only show PDF files
                                if (pathinfo($file, PATHINFO_EXTENSION) == 'pdf') {
                        ?>
                                    <tr>
                                        <td><?= htmlspecialchars($file); ?></td>
                                        <td>
                                            <a href="<?= $directory . $file; ?>" class="btn btn-success" download>Download</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="2" class="text-center">No PDFs found</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(4) a").addClass('active');
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