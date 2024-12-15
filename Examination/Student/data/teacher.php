<?php

function getTeacherById($teacher_id, $conn)
{
  $sql = "SELECT username FROM users
           WHERE user_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$teacher_id]);

  if ($stmt->rowCount() == 1) {
    $teacher = $stmt->fetch();
    return $teacher;
  } else {
    return 0;
  }
}

function getTeacherByCourse($course, $conn)
{
  $sql = "SELECT * FROM lecturemodules
           WHERE course=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$course]);

  if ($stmt->rowCount() >= 1) {
    $teacher = $stmt->fetchAll();
    return $teacher;
  } else {
    return 0;
  }
}