<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";

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
            $module = $_GET['module'];  // Retrieve the module parameter from URL
            $batch = $_GET['batch'] ?? null;  // Optional: Retrieve the batch if it's being used

            $sql = "SELECT reg_no, marks FROM $module";
            if ($batch) {
                $sql .= " WHERE batch = '$batch'";  // Optional: Filter by batch if it's provided
            }
            $stmt = $conn->query($sql);
            echo "<div class='container mt-5 shadow p-3 my-5 form-w'>";
            echo "<table class='table table-bordered mt-3 n-table'>";
            echo "<tr><th>Reg No</th><th>Marks</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>{$row['reg_no']}</td><td>{$row['marks']}</td></tr>";
            }
            echo "</table>";
            echo "<a href='marks.php'><button type='submit' name='save' class='btn btn-primary'>Go Back</button></a>";
            echo "</div>";
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
?>