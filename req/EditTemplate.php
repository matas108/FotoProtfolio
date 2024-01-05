<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {

    if (
        ((isset($_POST['text1']) && isset($_FILES['image1']) && isset($_POST['preImg1_url']) && isset($_POST['Img1_id'])) ||
            (isset($_POST['text2']) && isset($_FILES['image2']) && isset($_POST['preImg2_url']) && isset($_POST['Img2_id'])) ||
            (isset($_POST['text3']) && isset($_FILES['image3']) && isset($_POST['preImg3_url']) && isset($_POST['Img3_id']))) &&
        isset($_POST['type'])
    ) {
        include "../db_conn.php";
        include_once "../data/Template.php";
        $pictures = array(
            array($_FILES['image1'], test_input($_POST['text1']), $_POST['preImg1_url'], $_POST['Img1_id']),
            array($_FILES['image2'], test_input($_POST['text2']), $_POST['preImg2_url'], $_POST['Img2_id']),
            array($_FILES['image3'], test_input($_POST['text3']), $_POST['preImg3_url'], $_POST['Img3_id'])
        );

        $templateId = $_GET['templateId'];
        $type = $_POST['type'];
        $template = getTemplateById($conn, $templateId);
        $galleryId = $template['fkGalleryId'];


        $numInTemplate = 1;

        foreach ($pictures as $picture) {
            $image_name = $picture[0]['name'];
            $currentPicture = $picture[2];
            $image_id = $picture[3];

            if (($currentPicture != "default.jpg" || $currentPicture != "") && $image_name != "") {
                $clocation = '../uploads/' . $currentPicture;

                // delete the img
                unlink($clocation);
            }

            if ($image_name != "") {

                $image_temp = $picture[0]['tmp_name'];
                $error = $picture[0]['error'];
                if ($error === 0) {

                    $image_ex = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_ex = strtolower($image_ex);

                    $allowed_exs = array('jpg', 'jpeg', 'png');

                    if (in_array($image_ex, $allowed_exs)) {
                        $new_image_name = uniqid("IMG-", true) . '.' . $image_ex;
                        $image_path = '../uploads/' . $new_image_name;
                        move_uploaded_file($image_temp, $image_path);

                        $sql = "UPDATE nuotrauka SET imageURL=?, description=?, orderInTemplate=? WHERE photoId =?";
                        $stmt = $conn->prepare($sql);
                        $res = $stmt->execute([$new_image_name, $picture[1], $numInTemplate, $image_id]);
                    } else {
                        $em = "You can't upload files of this type";
                        echo $em;
                        header("Location: ../editTemplate.php?error=$em&templateId=$templateId");
                        exit;
                    }
                }

            } else {
                echo "no picture";
                $sql = "UPDATE nuotrauka SET description=?, orderInTemplate=? WHERE photoId =?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$picture[1], $numInTemplate, $image_id]);
            }
            if (!$res) {
                $em = "Unknown error occurred";
                echo $em;
                header("Location: ../editTemplate.php?error=$em&templateId=$templateId");
                exit;
            }
            $numInTemplate = $numInTemplate + 1;
        }

        if ($res) {
            $sm = "Successfully edited!";
            echo $sm;
            header("Location: ../editGallery.php?success=$sm&galleryId=$galleryId");
            exit;
        } else {
            $em = "Unknown error occurred";
            echo $em;
            header("Location: ../editTemplate.php?error=$em&templateId=$templateId");
            exit;
        }


    } else {
        echo "nothing set";
        header("Location: ../editTemplate.php&templateId=$templateId");
        exit;
    }


} else {
    header("Location: ../login.php");
    exit;
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}