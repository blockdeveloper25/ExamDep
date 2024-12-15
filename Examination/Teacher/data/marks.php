<?php

function getAllModules($conn, $course, $user_id)
{
    $sql = "SELECT * FROM lecturemodules
    WHERE user_id=? AND course=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id,$course]);

    if ($stmt->rowCount() == 1) {
        $teacher = $stmt->fetch();
        return $teacher;
    } else {
        return 0;
    }
}

function checkBatchExists($conn, $tableName, $batch) {
    try {
        // Prepare the SQL statement to check for the existence of the batch in the table
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `$tableName` WHERE batch = ?");
        $stmt->execute([$batch]);
        
        // Fetch the count of rows that match the batch
        $count = $stmt->fetchColumn();
        
        // Return true if there are any rows, false otherwise
        return $count > 0;
    } catch (PDOException $e) {
        // Handle potential exceptions such as when the table does not exist
        echo "Error: " . $e->getMessage();
        return false;
    }
}