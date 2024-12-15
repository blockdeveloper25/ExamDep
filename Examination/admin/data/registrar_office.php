<?php  

// Get r_user by ID
function getR_usersById($user_id, $conn){
   $sql = "SELECT * FROM users
           WHERE role='dephead' AND user_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$user_id]);

   if ($stmt->rowCount() == 1) {
     $dephead = $stmt->fetch();
     return $dephead;
   }else {
    return 0;
   }
}

// All r_users 
function getAllR_users($conn){
   $sql = "SELECT * FROM users WHERE role='dephead'";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $dephead = $stmt->fetchAll();
     return $dephead;
   }else {
   	return 0;
   }
}

// Check if the username Unique
function unameIsUnique($uname, $conn, $r_user_id=0){
   $sql = "SELECT username, user_id FROM users
           WHERE username=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$uname]);
   
   if ($r_user_id == 0) {
     if ($stmt->rowCount() >= 1) {
       return 0;
     }else {
      return 1;
     }
   }else {
    if ($stmt->rowCount() == 1) {
       $r_user = $stmt->fetch();
       if ($r_user['user_id'] == $r_user_id) {
         return 1;
       }else {
        return 0;
      }
     }else {
      return 1;
     }
   }
   
}

// DELETE
function removeRUser($id, $conn){
   $sql  = "DELETE FROM users
           WHERE user_id=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}