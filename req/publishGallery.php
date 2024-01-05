<?php
session_start();

if (
  isset($_SESSION['user_id']) &&
  isset($_SESSION['username']) &&
  isset($_GET['galleryId']) &&
  isset($_GET['publish'])
) {

  include_once("../db_conn.php");
  $galleryId = $_GET['galleryId'];
  $publish = $_GET['publish'];
  if ($publish) {
    $sql = "UPDATE galerija SET published=1
	          WHERE galleryId=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$galleryId]);
    $sm = "Successfully publish!";
    header("Location: ../gallery.php?success=$sm");
    exit;
  } else {
    $sql = "UPDATE galerija SET published=0
            WHERE galleryId=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$galleryId]);
    $sm = "Successfully unpublish!";
    header("Location: ../gallery.php?success=$sm");
    exit;
  }

} else {
  header("Location: ../login.php");
  exit;
}