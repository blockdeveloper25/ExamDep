<?php

function getallrequests($conn)
{
    // Fetching data from the database
    $sql = "SELECT * FROM recorrection";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $request = $stmt->fetchAll();
        return $request;
      }else {
          return 0;
      }
}

function getReqByID($conn,$req_id)
{
    $sql = "SELECT * FROM recorrection WHERE req_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$req_id]);

    if ($stmt->rowCount() == 1) {
        $request = $stmt->fetch();
        return $request;
      }else {
       return 0;
      }
}

function getReqByStatus($conn)
{
    $sql = "SELECT * FROM recorrection WHERE status = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $request = $stmt->fetchAll();
        return $request;
      }else {
       return 0;
      }
}
