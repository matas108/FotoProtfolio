<?php
session_start();

if (
    isset($_SESSION['user_id']) && isset($_SESSION['username'])
    && isset($_GET['templateId'])
) {

    $templateId = $_GET['templateId'];

    include_once("../data/Template.php");
    include_once("../data/Image.php");
    include_once("../db_conn.php");

    $template = getTemplateById($conn, $templateId);
    $galleryId = $template['fkGalleryId'];

    $images = getImagesByTemplateId($conn, $templateId);
    foreach ($images as $image) {

        $res = deleteByImageId($conn, $image['photoId']);
        if (!$res) {
            $em = "Unknown error occurred";
            header("Location: ../editGallery.php?error=$em&galleryId=$galleryId");
            exit;
        }

        $imageLocation = '../uploads/' . $image['imageURL'];
        unlink($imageLocation);

    }

    $res = deleteByTemplateId($conn, $templateId);
    if ($res) {
        $sm = "Successfully deleted!";
        header("Location: ../editGallery.php?success=$sm&galleryId=$galleryId");
        exit;
    } else {
        $em = "Unknown error occurred";
        header("Location: ../editGallery.php?error=$em&galleryId=$galleryId");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}