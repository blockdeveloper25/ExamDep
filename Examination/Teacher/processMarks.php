<?php
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";




        $module = $_POST['tableName'];  // Changed from 'subject_code' to match your form data
        $batch = $_POST['batch'];       // Ensure this is captured if it's sent
        $marks = $_POST['marks'];

        foreach ($marks as $reg_no => $mark) {
            $sql = "UPDATE $module SET marks = ? WHERE reg_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$mark, $reg_no]);
        }

        header("Location: viewMarks.php?module=$module&batch=$batch"); // Pass module and batch
        exit;
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
