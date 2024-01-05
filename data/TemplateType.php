<?php 

// Get All 
function getAllTypes($conn){
   $sql = "SELECT * FROM sablonotipas";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if($stmt->rowCount() >= 1){
   	   $data = $stmt->fetchAll();
   	   return $data;
   }else {
   	 return 0;
   }
}

// getById
function getTypesById($conn, $id){
   $sql = "SELECT * FROM sablonotipas WHERE sablonoTipasId=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
         $data = $stmt->fetch();
         return $data;
   }else {
       return 0;
   }
}