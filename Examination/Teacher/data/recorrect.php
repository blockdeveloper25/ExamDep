<?php

function getRecorrectReq($conn, $username){
    $sql = "SELECT * FROM recorrection WHERE approved = 1 AND teacher_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() >= 1) {
        $req = $stmt->fetchAll();
        return $req;
      }else {
          return 0;
      }
}

function getALLRecorrectReq($conn, $username){
    $sql = "SELECT * FROM recorrection WHERE teacher_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() >= 1) {
        $req = $stmt->fetchAll();
        return $req;
      }else {
          return 0;
      }
}




