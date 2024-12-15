<?php  

// Get Teacher by ID
function getTeacherById($teacher_id, $conn){
   $sql = "SELECT * FROM users
           WHERE user_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$teacher_id]);

   if ($stmt->rowCount() == 1) {
     $teacher = $stmt->fetch();
     return $teacher;
   }else {
    return 0;
   }
}

function getLectureModulesById($teacher_id, $conn, $course){
  $sql = "SELECT * FROM lecturemodules
          WHERE user_id=? AND course=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$teacher_id,$course]);

  if ($stmt->rowCount() == 1) {
    $teacher = $stmt->fetch();
    return $teacher;
  }else {
   return 0;
  }
}

function studentPasswordVerify($student_pass, $conn, $student_id){
  $sql = "SELECT * FROM students
          WHERE student_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$student_id]);

  if ($stmt->rowCount() == 1) {
    $student = $stmt->fetch();
    $pass  = $student['password'];

    if (password_verify($student_pass, $pass)) {
       return 1;
    }else {
       return 0;
    }
  }else {
   return 0;
  }
}


