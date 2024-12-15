<?php

// All Students 
function getAllStudentsByCourse($conn,$course)
{
  $sql = "SELECT * FROM users WHERE role='student' AND department = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$course]);

  if ($stmt->rowCount() >= 1) {
    $students = $stmt->fetchAll();
    return $students;
  } else {
    return 0;
  }
}



// Get Student By Id 
function getStudentById($id, $conn)
{
  $sql = "SELECT * FROM users
           WHERE user_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);

  if ($stmt->rowCount() == 1) {
    $student = $stmt->fetch();
    return $student;
  } else {
    return 0;
  }
}


// Check if the username Unique
function getDepHeadById($conn, $id)
{
  $sql = "SELECT * FROM users
  WHERE user_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);

  if ($stmt->rowCount() == 1) {
    $student = $stmt->fetch();
    return $student;
  } else {
    return 0;
  }
}
