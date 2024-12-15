<?php 
session_start();

if (isset($_POST['uname']) &&
    isset($_POST['pass']) ) {

	include "../DB_connection.php";
	
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	error_reporting(E_ALL);
        ini_set('display_errors', 1);
	

	if (empty($uname)) {
		$em  = "Username is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../login.php?error=$em");
		exit;
	
	}else {
        $sql = "SELECT * FROM users 
        	        WHERE username = ?";
        

        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1) {
        	$user = $stmt->fetch();
        	$username = $user['username'];
        	$password = $user['password'];
			$role = $user['role'];
        	
            if ($username === $uname) {
            	if (password_verify($pass, $password)) {
            		$_SESSION['role'] = $role;
            		if ($role == 'admin') {
                        $id = $user['user_id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../admin/index.php");
                        exit;
                    }else if ($role == 'student') {
                        $id = $user['user_id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../Student/index.php");
                        exit;
                    }else if ($role == 'dephead') {
                        $id = $user['user_id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../RegistrarOffice/index.php");
                        exit;
                    }else if($role == 'teacher'){
                    	$id = $user['user_id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../Teacher/index.php");
                        exit;
                    }else {
                    	$em  = "Incorrect Username or Password";
				        header("Location: ../login.php?error=$em");
				        exit;
                    }
				    
            	}else {
		        	$em  = "Incorrect Username or Password";
				    header("Location: ../login.php?error=$em");
				    exit;
		        }
            }else {
	        	$em  = "Incorrect Username or Password";
			    header("Location: ../login.php?error=$em");
			    exit;
	        }
        }else {
        	$em  = "Incorrect Username or Password";
		    header("Location: ../login.php?error=$em");
		    exit;
        }
	}


}else{
	header("Location: ../login.php");
	exit;
}