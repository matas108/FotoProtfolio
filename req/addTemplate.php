<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {

    if (
        ((isset($_POST['text1']) && isset($_FILES['image1'])) ||
            (isset($_POST['text2']) && isset($_FILES['image2'])) ||
            (isset($_POST['text3']) && isset($_FILES['image3']))) &&
        isset($_POST['type'])
    ) {
        include "../db_conn.php";
        include_once "../data/Template.php";
        $pictures = array(
            array($_FILES['image1'], test_input($_POST['text1'])),
            array($_FILES['image2'], test_input($_POST['text2'])),
            array($_FILES['image3'], test_input($_POST['text3']))
        );

        $galleryId = $_GET['galleryId'];
        $type = $_POST['type'];
        $sql = "INSERT INTO sablonas(sablonoTipas, fkGalleryId) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$type, $galleryId]);
        if (!$res) {
            $em = "Unknown error occurred";
            echo $em;
            header("Location: ../createTemplate.php?error=$em&galleryId=$galleryId");
            exit;
        }
        $template = getNewestTemplate($conn, $galleryId);
        $templateId = $template['templateId'];

        $numInTemplate = 1;

        foreach ($pictures as $picture) {
            $image_name = $picture[0]['name'];
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

                        $sql = "INSERT INTO nuotrauka(imageURL, description, orderInTemplate, fkTemplateId) VALUES (?,?,?,?)";
                        $stmt = $conn->prepare($sql);
                        $res = $stmt->execute([$new_image_name, $picture[1], $numInTemplate, $templateId]);
                    } else {
                        $em = "You can't upload files of this type";
                        echo $em;
                        header("Location: ../createTemplate.php?error=$em&galleryId=$galleryId");
                        exit;
                    }
                }

            } else {
                echo "no picture";
                $sql = "INSERT INTO nuotrauka(description, orderInTemplate, fkTemplateId) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$picture[1], $numInTemplate, $templateId]);
            }
            if (!$res) {
                $em = "Unknown error occurred";
                echo $em;
                header("Location: ../createTemplate.php?error=$em&galleryId=$galleryId");
                exit;
            }
            $numInTemplate = $numInTemplate + 1;
        }

        if ($res) {
            $sm = "Successfully Created!";
            echo $sm;
            header("Location: ../editGallery.php?success=$sm&galleryId=$galleryId");
            exit;
        } else {
            $em = "Unknown error occurred";
            echo $em;
            header("Location: ../createTemplate.php?error=$em&galleryId=$galleryId");
            exit;
        }


    } else {
        echo "nothing set";
        header("Location: ../createTemplate.php&galleryId=$galleryId");
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