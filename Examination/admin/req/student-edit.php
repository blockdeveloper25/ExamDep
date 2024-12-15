<?php 
session_start();
if (
    isset($_SESSION['id']) &&
    isset($_SESSION['role'])
  ) {
  
    if ($_SESSION['role'] == 'admin') {
        

if (isset($_POST['fname'])      &&
    isset($_POST['lname'])      &&
    isset($_POST['username'])   &&
    isset($_POST['student_id']) &&
    isset($_POST['address'])    &&
    isset($_POST['email_address']) &&
    isset($_POST['gender'])        &&
    isset($_POST['date_of_birth']) &&
    isset($_POST['course'])  &&
    isset($_POST['parent_fname'])  &&
    isset($_POST['parent_lname'])  &&
    isset($_POST['parent_phone_number']) ) {
    
    include '../../DB_connection.php';
    include "../data/student.php";

    error_reporting(E_ALL);
        ini_set('display_errors', 1);

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['username'];

    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $email_address = $_POST['email_address'];
    $date_of_birth = $_POST['date_of_birth'];
    $parent_fname = $_POST['parent_fname'];
    $parent_lname = $_POST['parent_lname'];
    $parent_phone_number = $_POST['parent_phone_number'];
    $course = $_POST['course'];
    $student_id = $_POST['student_id'];
    
   

    $data = 'student_id='.$student_id;

    if (empty($fname)) {
        $em  = "First name is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Last name is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (!unameIsUnique($uname, $conn, $student_id)) {
        $em  = "Username is taken! try another";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($address)) {
        $em  = "Address is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($gender)) {
        $em  = "Gender is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($email_address)) {
        $em  = "Email address is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($date_of_birth)) {
        $em  = "Date of birth is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($parent_fname)) {
        $em  = "Parent first name is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($parent_lname)) {
        $em  = "Parent last name is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else if (empty($parent_phone_number)) {
        $em  = "Parent phone number is required";
        header("Location: ../student-edit.php?error=$em&$data");
        exit;
    }else {
        $sql = "UPDATE users SET
                username = ?, fname=?, lname=?,course=?,  address=?,gender = ?, email_address=?, date_of_birth=?, parent_fname=?,parent_lname=?,parent_phone_number=?
                WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname,$fname, $lname,$course, $address, $gender, $email_address, $date_of_birth, $parent_fname, $parent_lname,$parent_phone_number, $student_id]);
        $sm = "successfully updated!";
        header("Location: ../student-edit.php?success=$sm&$data");
        exit;
    }
    
  }else {
    $em = "An error occurred";
    header("Location: ../student.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
    header("Location: ../../logout.php");
    exit;
} 
