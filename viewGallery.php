<?php
session_start();
$logged = false;

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}

if (isset($_GET['galleryId'])) {

    include_once("data/Gallery.php");
    include_once("data/Template.php");
    include_once("data/Image.php");
    include_once("db_conn.php");

    $id = $_GET['galleryId'];
    $gallery = getGalleryById($conn, $id);
    $templates = getByGalleryId($conn, $id);

    if ($templates == 0) {
        header("Location: gallery.php");
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gallery -
            <?= $gallery['title'] ?>
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

        <!-- <style>
            .temp img {
                max-width: 720px;
                max-height: 480px;
            }
        </style> -->

    </head>

    <body>
        <?php
        include 'NavBar.php';
        ?>

        <div class="container mt-5">
            <section class="d-flex">

                <main>
                    <h1 class="text-center">
                        <?= $gallery['title'] ?>
                    </h1>

                    <?php foreach ($templates as $template) {
                        $images = getImagesByTemplateId($conn, $template['templateId']);
                        if ($template['sablonoTipas'] == 1) { ?>

                            <div class="row row-cols-2 justify-content-evenly align-items-center py-5 px-2">
                                <div class="col-6">
                                    <div class="temp">
                                        <img src="uploads/<?=$images[0]['imageURL']?>" class="mx-auto d-block img-fluid">
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <p><?=$images[0]['description']?></p>
                                </div>
                            </div>


                            <div class="row row-cols-2 justify-content-evenly align-items-center py-5 px-2">
                                <div class="col-6">
                                    <div class="temp">
                                        <img src="uploads/<?=$images[1]['imageURL']?>" class="mx-auto d-block img-fluid">
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <p><?=$images[1]['description']?></p>
                                </div>
                            </div>



                            <div class="row row-cols-2 justify-content-evenly align-items-center py-5 px-2">
                                <div class="col-6">
                                    <div class="temp">
                                        <img src="uploads/<?=$images[2]['imageURL']?>" class="mx-auto d-block img-fluid">
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <p><?=$images[2]['description']?></p>
                                </div>
                            </div>

                            

                        <?php } ?>
                        <?php if ($template['sablonoTipas'] == 2) { ?>

                            <div class="row row-cols-3 justify-content-center align-items-center">
                                <div class="col-4">
                                    <div class="temp">
                                        <img src="uploads/<?=$images[0]['imageURL']?>" class="mx-auto d-block img-fluid">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="temp">
                                        <img src="uploads/<?=$images[1]['imageURL']?>" class="mx-auto d-block img-fluid">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="temp">
                                        <img src="uploads/<?=$images[2]['imageURL']?>" class="mx-auto d-block img-fluid">
                                    </div>
                                </div>

                                <div class="col-4 ">
                                    <p><?=$images[0]['description']?></p>
                                </div>
                                <div class="col-4 ">
                                    <p><?=$images[1]['description']?></p>
                                </div>
                                <div class="col-4 ">
                                    <p><?=$images[2]['description']?></p>
                                </div>

                            </div>

                        <?php } ?>
                    <?php } ?>

                </main>

            </section>
        </div>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    header("Location: gallery.php");
    exit;
} ?>