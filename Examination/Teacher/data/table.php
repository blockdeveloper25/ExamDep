<?php
function fetchTableData($conn, $tableName) {
    try {
        $sql = "SELECT reg_no, marks FROM $tableName";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // You can check the error code or error message if it's specific to table not found
        // Error handling depending on the type of database you are using
        if ($e->getCode() == '42S02') { // MySQL code for "Base table or view not found"
            return null; // or you can return an error message or code
        }
        throw $e; // rethrow the exception if it's not related to table existence
    }
}
