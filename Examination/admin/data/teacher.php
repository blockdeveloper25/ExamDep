<?php

// Get Teacher by ID
function getTeacherById($teacher_id, $conn)
{
  $sql = "SELECT * FROM users
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

// All Teachers 
function getAllTeachers($conn)
{
  $sql = "SELECT * FROM users WHERE role='teacher'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  if ($stmt->rowCount() >= 1) {
    $teachers = $stmt->fetchAll();
    return $teachers;
  } else {
    return 0;
  }
}

function getCourseByID($conn, $user_id)
{
  $sql = "SELECT course FROM users WHERE user_id = $user_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  if ($stmt->rowCount() == 1) {
    $course = $stmt->fetch();
    return $course;
  } else {
    return 0;
  }
}


// Check if the username Unique
function unameIsUnique($uname, $conn, $teacher_id = 0)
{
  $sql = "SELECT username, user_id FROM users
           WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$uname]);

  if ($teacher_id == 0) {
    if ($stmt->rowCount() >= 1) {
      return 0;
    } else {
      return 1;
    }
  } else {
    if ($stmt->rowCount() >= 1) {
      $teacher = $stmt->fetch();
      if ($teacher['user_id'] == $teacher_id) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 1;
    }
  }
}

// DELETE
function removeTeacher($id, $conn)
{
    try {
        // Start a transaction to ensure both deletes succeed or fail together
        $conn->beginTransaction();

        // Delete from lecturemodules table
        $sql_modules = "DELETE FROM lecturemodules WHERE user_id=?";
        $stmt_modules = $conn->prepare($sql_modules);
        $re_modules = $stmt_modules->execute([$id]);

        // Delete from users table
        $sql_users = "DELETE FROM users WHERE user_id=?";
        $stmt_users = $conn->prepare($sql_users);
        $re_users = $stmt_users->execute([$id]);

        // Check if both queries were successful
        if ($re_users && $re_modules) {
            // Commit the transaction
            $conn->commit();
            return 1;
        } else {
            // Rollback the transaction if something went wrong
            $conn->rollBack();
            return 0;
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();
        return 0;
    }
}


// Search 
function searchTeachers($key, $conn)
{
  $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1', $key);

  $sql = "SELECT * FROM users
           WHERE role ='teacher' &&
           user_id LIKE ? 
           OR fname LIKE ?
           OR lname LIKE ?
           OR username LIKE ?
           OR employee_number LIKE ?
           OR phone_number LIKE ?
           OR qualification LIKE ?
           OR email_address LIKE ?
           OR address LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$key, $key, $key, $key, $key, $key, $key, $key, $key]);

  if ($stmt->rowCount() == 1) {
    $teachers = $stmt->fetchAll();
    return $teachers;
  } else {
    return 0;
  }
}
