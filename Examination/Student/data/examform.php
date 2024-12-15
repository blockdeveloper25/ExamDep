<?php

function getVisisbilityByFacSem($conn, $fac)
{
    $sql = "SELECT * FROM formcontrol
    WHERE faculty=? ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$fac]);

    if ($stmt->rowCount() == 1) {
        $student = $stmt->fetch();
        return $student;
    } else {
        return 0;
    }
}



function getNotification($conn, $conf)
{
    $sql = "SELECT * FROM notification
    WHERE value=? ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$conf]);

    if ($stmt->rowCount() == 1) {
        $mess = $stmt->fetch();
        return $mess;
    } else {
        return 0;
    }
}
