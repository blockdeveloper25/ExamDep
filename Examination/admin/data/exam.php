<?php
function getAllControls($conn)
{
    // Fetching data from the database
    $sql = "SELECT * FROM formcontrol";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $request = $stmt->fetchAll();
        return $request;
    } else {
        return 0;
    }
}


function fetchStudentData($conn,$fac,$course)
{
    // Construct the SQL query
    $sql = "SELECT id, username, confirm FROM users 
            WHERE role = 'students' 
            AND Faculty = ? 
            AND course = ? 
            AND confirm = 1 
            AND request = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$fac,$course]);

    if ($stmt->rowCount() == 1) {
        $students = $stmt->fetch();
        return $students;
      }else {
       return 0;
      }


}

function getSemByConfirmation($conn, $student_id)
{
    $sql = "SELECT confirmation FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id]);

    if ($stmt->rowCount() == 1) {
        // Fetch the confirmation directly as an integer
        $confirmation = (int)$stmt->fetchColumn();

        switch ($confirmation) {
            case 0:
                return 1;
                exit;
            case 1:
                return 'sem1';
                exit;
            case 2:
                return 'sem2';
                exit;
            case 3:
                return 'sem3';
                exit;
            case 4:
                return 'sem4';
                exit;
            case 5:
                return 'sem5';
                exit;
            case 6:
                return 'sem6';
                exit;
            case 7:
                return 'sem7';
                exit;
            case 8:
                return 'sem8';
                exit;
            default:
                return 2; // Handle unexpected values
        }
    }
    return 'No data found'; // Handle cases where no user is found
}
