<?php
session_start();

if (
    isset($_SESSION['user_id']) && isset($_SESSION['username'])
    && isset($_GET['galleryId'])
) {

    $galleryId = $_GET['galleryId'];

    include_once("../data/Gallery.php");
    include_once("../data/Template.php");
    include_once("../data/Image.php");
    include_once("../db_conn.php");

    $templates = getByGalleryId($conn, $galleryId);
    foreach ($templates as $template) {

        $images = getImagesByTemplateId($conn, $template['templateId']);
        foreach ($images as $image) {

            $res = deleteByImageId($conn, $image['photoId']);
            if (!$res) {
                $em = "Unknown error occurred";
                header("Location: ../gallery.php?error=$em");
                exit;
            }

            $imageLocation = '../uploads/' . $image['imageURL'];
            unlink($imageLocation);

        }

        $res = deleteByTemplateId($conn, $template['templateId']);
        if (!$res) {
            $em = "Unknown error occurred";
            header("Location: ../gallery.php?error=$em");
            exit;
        }

    }

    $res = deleteByGalleryId($conn, $galleryId);
    if ($res) {
        $sm = "Successfully deleted!";
        header("Location: ../gallery.php?success=$sm");
        exit;
    } else {
        $em = "Unknown error occurred";
        header("Location: ../gallery.php?error=$em");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}