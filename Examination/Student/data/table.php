<?php
function getAllTableNames($conn)
{
    $stmt = $conn->query("SHOW TABLES");
    $tables = [];
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    return $tables;
}

function findTablesByBatchValue(array $tableNames, $conn, $batch)
{
    $tablesContainingValue = [];

    foreach ($tableNames as $tableName) {
        // Prepare the SQL statement
        $sql = "SELECT * FROM ". $tableName ." WHERE batch =? LIMIT 1"; // Limit 1, as we only need to know if at least one row exists
        $stmt = $conn->prepare($sql);

        // Execute the query
        try {
            $stmt->execute([$batch]);

            // Check if any rows are returned
            if ($stmt->rowCount() > 0) {
                $tablesContainingValue[] = $tableName;
            }
        } catch (PDOException $e) {
            // Handle potential errors like nonexistent tables or lack of permissions gracefully
            echo "Error accessing table $tableName: " . $e->getMessage() . "<br/>";
            continue;
        }
    }

    // Return the array with table names or null if empty
    return !empty($tablesContainingValue) ? $tablesContainingValue : null;
}


function getMarksByRegNo($tableName, $reg_no, $conn)
{
    $sql = "SELECT marks FROM $tableName WHERE reg_no =?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$reg_no]);

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch as an associative array
        return $row['marks'];
    } else {
        return 0;
    }
}

function getSubjectCodesBySem($column, $course, $conn)
{
    $sql = "SELECT $column FROM course_code WHERE course =?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$course]);

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch as an associative array
        return $row[$column];
    } else {
        return 0;
    }
}



function gradeCalc($grade)
{
    $g = "";
    if ($grade >= 92) {
        $g = "A+";
    } else if ($grade >= 86) {
        $g = "A";
    } else if ($grade >= 80) {
        $g = "A-";
    } else if ($grade >= 75) {
        $g = "B+";
    } else if ($grade >= 70) {
        $g = "B";
    } else if ($grade >= 66) {
        $g = "B-";
    } else if ($grade >= 60) {
        $g = "C";
    } else if ($grade >= 55) {
        $g = "C-";
    } else if ($grade >= 50) {
        $g = "D+";
    } else if ($grade >= 45) {
        $g = "D";
    } else if ($grade >= 40) {
        $g = "D-";
    } else if ($grade < 39) {
        $g = "F";
    }
    return $g;
}
