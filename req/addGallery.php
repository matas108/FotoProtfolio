<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username']) ) {

    if(isset($_POST['title'])){
      include "../db_conn.php";
      $title = test_input($_POST['title']);

      if(empty($title)){
         $em = "title is required"; 
         header("Location: ../createGallery.php?error=$em");
         exit;
      }
    
      $sql = "INSERT INTO galerija(title,fkUserId	) VALUES (?,?)";
      $stmt = $conn->prepare($sql);
      $res = $stmt->execute([$title, $_SESSION['user_id']]);
    
      
     if ($res) {
          $sm = "Successfully Created!"; 
          header("Location: ../gallery.php?success=$sm");
          exit;
      }else {
        $em = "Unknown error occurred"; 
        header("Location: ../createGallery.php?error=$em");
        exit;
      }


    }else {
        header("Location: ../createGallery.php");
        exit;
    }


}else {
    header("Location: ../gallery.php");
    exit;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}