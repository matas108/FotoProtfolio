<?php 

// Get All 

function getAllUserDeep($conn){
   $sql = "SELECT userId, username, timestamp FROM vartotojas WHERE userLevel != 2 ORDER BY userId DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if($stmt->rowCount() >= 1){
   	   $data = $stmt->fetchAll();
   	   return $data;
   }else {
   	 return 0;
   }
}

function getAllUserByUsername($conn, $name){
   $sql = "SELECT username, timestamp FROM vartotojas WHERE userLevel != 2 && username=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$name]);

   if($stmt->rowCount() >= 1){
   	   $data = $stmt->fetchAll();
   	   return $data;
   }else {
   	 return 0;
   }
}

function deleteByUserId($conn, $id){
   $sql = "DELETE FROM vartotojas WHERE userId=?";
   $stmt = $conn->prepare($sql);
   $res = $stmt->execute([$id]);

   if($res){
   	   return 1;
   }else {
   	 return 0;
   }
}

