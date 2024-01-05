<?php
session_start();

if (
    isset($_SESSION['admin_id']) && isset($_SESSION['username'])
    && isset($_GET['id'])
) {

    $userId = $_GET['id'];

    include_once("../../data/User.php");
    include_once("../../data/Gallery.php");
    include_once("../../data/Template.php");
    include_once("../../data/Image.php");
    include_once("../../db_conn.php");

    $galleries = getByUserId($conn, $userId);
    foreach ($galleries as $gallery) {

        $templates = getByGalleryId($conn, $gallery['galleryId']);
        foreach ($templates as $template) {

            $images = getImagesByTemplateId($conn, $template['templateId']);
            foreach ($images as $image) {

                $res = deleteByImageId($conn, $image['photoId']);
                if (!$res) {
                    $em = "Unknown error occurred";
                    header("Location: ../userList.php?error=$em");
                    exit;
                }

                $imageLocation = '../../uploads/' . $image['imageURL'];
                unlink($imageLocation);

            }

            $res = deleteByTemplateId($conn, $template['templateId']);
            if (!$res) {
                $em = "Unknown error occurred";
                header("Location: ../userList.php?error=$em");
                exit;
            }

        }

        $res = deleteByGalleryId($conn, $gallery['galleryId']);
        if (!$res) {
            $em = "Unknown error occurred";
            header("Location: ../gallery.php?error=$em");
            exit;
        }
    }

    $res = deleteByUserId($conn, $userId);
    if ($res) {
        $sm = "Successfully deleted!";
        header("Location: ../userList.php?success=$sm");
        exit;
    } else {
        $em = "Unknown error occurred";
        header("Location: ../userList.php?error=$em");
        exit;
    }

} else {
    header("Location: ../admiLogin.php");
    exit;
}