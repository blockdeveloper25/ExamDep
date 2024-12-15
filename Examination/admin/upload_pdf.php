<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'admin') {
        include "../DB_connection.php"; // Ensure this path is correct
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $message = "";

        if (isset($_POST['submit'])) {
            $targetDir = "timetables/";
            $fileName = basename($_FILES["fileUpload"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            if ($fileType == 'pdf') {
                if (!file_exists($targetFilePath)) {
                    if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetFilePath)) {
                        // Store a success message in session or similar storage
                        $_SESSION['message'] = "<div class='alert alert-success'>The file " . htmlspecialchars($fileName) . " has been uploaded.</div>";
                        // Redirect to the same page or a confirmation page
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        $_SESSION['message'] = "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    }
                } else {
                    $_SESSION['message'] = "<div class='alert alert-danger'>Sorry, file already exists.</div>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            } else {
                $_SESSION['message'] = "<div class='alert alert-danger'>Sorry, only PDF files are allowed.</div>";
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);  // Clear the message from the session
        }
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin - Serach Teachers</title>
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
            <div class="container mt-5">
                <h1>Upload Timetable PDF</h1>
                <form action="upload_pdf.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">Select PDF file:</label>
                        <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Upload File</button>
                    <a href="index.php"><button type="submit" class="btn btn-primary" name="back">Go back</button></a>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">File Upload Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?= $message; ?>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                <?php if ($message) : ?>
                    $(document).ready(function() {
                        $('#feedbackModal').modal('show');
                    });
                <?php endif; ?>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(7) a").addClass('active');
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