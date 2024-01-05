<?php 

// Get All 

function getAllGalleryDeep($conn){
   $sql = "SELECT * FROM galerija ORDER BY galleryId DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if($stmt->rowCount() >= 1){
   	   $data = $stmt->fetchAll();
   	   return $data;
   }else {
   	 return 0;
   }
}

function getAllGallery($conn){
   $sql = "SELECT * FROM galerija WHERE published=1 ORDER BY galleryId DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if($stmt->rowCount() >= 1){
   	   $data = $stmt->fetchAll();
   	   return $data;
   }else {
   	 return 0;
   }
}

function getByUserId($conn, $id){
   $sql = "SELECT * FROM galerija WHERE fkUserId=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
         $data = $stmt->fetchAll();
         return $data;
   }else {
       return 0;
   }
}

function getGalleryById($conn, $id){
   $sql = "SELECT * FROM galerija WHERE galleryId=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
         $data = $stmt->fetch();
         return $data;
   }else {
       return 0;
   }
}

// Delete By ID
function deleteByGalleryId($conn, $id){
   $sql = "DELETE FROM galerija WHERE galleryId=?";
   $stmt = $conn->prepare($sql);
   $res = $stmt->execute([$id]);

   if($res){
   	   return 1;
   }else {
   	 return 0;
   }
}