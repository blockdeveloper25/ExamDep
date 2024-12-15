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
        $id = $_GET["id"];
        $user = getStudentById($id,$conn);
        // Hardcoding test values for this example
        
        $uName = $user['username'];
        $pname = $uName;
        $pprice = 300;

        // Assuming session has user data (change as per your session structure)
        
        
        $uMobile = $user['phone_number'];
        $batch = $user['batch'];
        $order_id = "ItemNo12345";  // Unique order ID
        $merchant_id = "1228461";  // Replace with your Merchant ID
        $merchant_secret = "Mzg5MDUxNjQyMDQ3MjIwMzQ0OTE3MjU2NjkxODEzNzkxMjc4NTI2";  // Replace with your Merchant Secret
        
        // Generating hash for payment
        $hash = strtoupper(
            md5(
                $merchant_id .
                $order_id .
                number_format($pprice, 2, '.', '') .  // Fix: $pprice is the amount
                "LKR" .  // Fix: Include the currency
                strtoupper(md5($merchant_secret))
            )
        );

        // Prepare response as JSON
        $response = array(
            "pn" => $pname,
            "pp" => $pprice,
            "un" => $uName,
            "um" => $uMobile,
            "btc" => $batch,
            "hash" => $hash
        );

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    echo "3";  // Invalid session
}
