<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'student') {
        // include "../DB_connection.php";

        // // Retrieve payment details from AJAX POST request
        // $student_id = $_POST['student_id'];
        // $username = $_POST['username'];
        // $amount = $_POST['amount'];
        // $payment_date = $_POST['payment_date'];
        // $batch = $_POST['batch'];
        // $pay_conf = 1; // Assuming a successful payment confirmation

        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);

        // // Function to update payment confirmation
        // function pay_conf($conn, $id, $num) {
        //     $sql = "UPDATE users SET pay_con = :pay_con WHERE user_id = :user_id";
        //     $stmt = $conn->prepare($sql);
        //     $stmt->bindParam(':pay_con', $num);
        //     $stmt->bindParam(':user_id', $id);
        //     $stmt->execute();
        // }

        // try {
        //     // Insert payment details into the 'pay_sem' table
        //     $sql = "INSERT INTO pay_sem (user_name, amount, pay_date, batch) VALUES (:username, :amount, :payment_date, :batch)";

        //     // Prepare the statement
        //     $stmt = $conn->prepare($sql);

        //     // Bind parameters
        //     $stmt->bindParam(':username', $username);
        //     $stmt->bindParam(':amount', $amount);
        //     $stmt->bindParam(':payment_date', $payment_date);
        //     $stmt->bindParam(':batch', $batch);

        //     // Execute the insertion
        //     if ($stmt->execute()) {
        //         // Update payment confirmation
        //         pay_conf($conn, $student_id, $pay_conf);
        //         echo "Payment details stored successfully";
        //     } else {
        //         echo "Failed to store payment details";
        //     }
        // } catch (PDOException $e) {
        //     echo "Failed to store payment details: " . $e->getMessage();
        // }
        echo "Sujair";
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    echo "Invalid session";
}
