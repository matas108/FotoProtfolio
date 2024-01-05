<?php 

function getImagesByTemplateId($conn, $id){
   $sql = "SELECT * FROM nuotrauka WHERE fkTemplateId=? ORDER BY orderInTemplate";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
         $data = $stmt->fetchAll();
         return $data;
   }else {
       return 0;
   }
}

function getImageByGalleryId($conn, $id){
   $sql = "SELECT imageURL FROM nuotrauka LEFT JOIN sablonas ON nuotrauka.fkTemplateId = sablonas.templateId LEFT JOIN galerija ON sablonas.fkGalleryId = galerija.galleryId WHERE galleryId=?";
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
function deleteByImageId($conn, $id){
   $sql = "DELETE FROM nuotrauka WHERE photoId=?";
   $stmt = $conn->prepare($sql);
   $res = $stmt->execute([$id]);

   if($res){
   	   return 1;
   }else {
   	 return 0;
   }
}