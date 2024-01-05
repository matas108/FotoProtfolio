<?php 

function getByGalleryId($conn, $id){
   $sql = "SELECT * FROM sablonas WHERE fkGalleryId=? ORDER BY templateId DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
         $data = $stmt->fetchAll();
         return $data;
   }else {
       return 0;
   }
}

function getTemplateById($conn, $id){
   $sql = "SELECT * FROM sablonas WHERE templateId=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
         $data = $stmt->fetch();
         return $data;
   }else {
       return 0;
   }
}

function getNewestTemplate($conn, $id){
   $sql = "SELECT * FROM sablonas WHERE fkGalleryId=? ORDER BY templateId DESC";
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
function deleteByTemplateId($conn, $id){
   $sql = "DELETE FROM sablonas WHERE templateId=?";
   $stmt = $conn->prepare($sql);
   $res = $stmt->execute([$id]);

   if($res){
   	   return 1;
   }else {
   	 return 0;
   }
}