<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $module = $_GET['module'];
        $batch = $_GET['batch'];

        $sqlInsert = "INSERT INTO $module (reg_no, batch) SELECT username, batch FROM users WHERE batch = ?";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->execute([$batch]);

        // Display the form for entering marks
        $sql = "SELECT reg_no, marks FROM $module WHERE batch = '$batch'";
        $stmt = $conn->query($sql);
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
            // Ensure this form sends both the module and batch if needed in processMarks.php
            echo "<form action='processMarks.php' method='post' class='container mt-5 shadow p-3 my-5 form-w'>";
            echo "<input type='hidden' name='tableName' value='$module'>";
            echo "<input type='hidden' name='batch' value='$batch'>"; // Ensure batch is also sent if needed
            echo "<table class='table table-bordered'>";
            echo "<thead class='table-dark'><tr><th>Registration No</th><th>Marks</th></tr></thead>";
            echo "<tbody>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>{$row['reg_no']}</td>";
                echo "<td><input type='number' name='marks[{$row['reg_no']}]' class='form-control'  value='{$row['marks']}' required ></td></tr>";
            }
            echo "</tbody></table>";
            echo "<button type='submit' name='save' class='btn btn-primary'>Done</button>";
            echo "</form>";

            ?>
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
                    $("#navLinks li:nth-child(5) a").addClass('active');
                });
            </script>

        </body>



<?php
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
