<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
  ) {
  
    if ($_SESSION['role'] == 'teacher') {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        include "../DB_connection.php";
        $tableName = $_GET['tableName'] ?? 'default_table_name';
        // Prepare and execute the query safely
        $sql = "SELECT reg_no, marks FROM " . htmlspecialchars($tableName);
        $stmt = $conn->prepare($sql);
        $stmt->execute();



?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Teacher - Students Grade</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php
            include "inc/navbar.php";
            echo '<div class="container mt-4">';
            echo '<h2>Student Marks for ' . htmlspecialchars($tableName) . '</h2>';
            echo '<table class="table table-striped">';
            echo '<thead class="thead-dark">';
            echo '<tr><th>Registration No</th><th>Marks</th></tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr><td>' . htmlspecialchars($row['reg_no']) . '</td><td>' . htmlspecialchars($row['marks']) . '</td></tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '<a href="index.php"><button class="btn btn-primary">Go Back to Home</button></a>';
            echo '</div>'; // Close container
            ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(5) a").addClass('active');
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