<?php
session_start();

if (
   isset($_POST['uname']) &&
   isset($_POST['pass'])
) {

   include "../db_conn.php";

   $uname = $_POST['uname'];
   $pass = $_POST['pass'];

   $data = "uname=" . $uname;

   if (empty($uname)) {
      $em = "User name is required";
      header("Location: ../admin-login.php?error=$em&$data");
      exit;
   } else if (empty($pass)) {
      $em = "Password is required";
      header("Location: ../admin-login.php?error=$em&$data");
      exit;
   } else {

      $sql = "SELECT * FROM vartotojas WHERE username = ? && userLevel = 2";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$uname]);

      if ($stmt->rowCount() == 1) {
         $user = $stmt->fetch();

         $username = $user['username'];
         $password = $user['password'];
         $id = $user['userId'];
         if ($username === $uname) {
            if (password_verify($pass, $password)) {

               $_SESSION['user_id'] = $id;
               $_SESSION['username'] = $username;
               $_SESSION['admin_id'] = $id;

               // echo $_SESSION['user_id'];
               // echo $_SESSION['username'];
               //header("Location: ../admin/userList.php");
               header("Location: ../index.php");
               exit;
            } else {
               $em = "Incorect User name or password";
               header("Location: ../admin-login.php?error=$em&$data");
               exit;
            }

         } else {
            $em = "Incorect User name or password";
            header("Location: ../admin-login.php?error=$em&$data");
            exit;
         }

      } else {
         $em = "Incorect User name or password";
         header("Location: ../admin-login.php?error=$em&$data");
         exit;
      }
   }


} else {
   header("Location: ../login.php?error=error");
   exit;
}
