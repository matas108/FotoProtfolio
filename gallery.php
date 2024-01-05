<?php
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galleries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body>

    <?php
    include 'NavBar.php';
    include_once("db_conn.php");
    include_once("data/Gallery.php");
    include_once("data/Image.php");

    if ($logged) {
        $gallerys = getByUserId($conn, $_SESSION['user_id']);
    } else {
        $gallerys = getAllGallery($conn);
    } ?>

    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <?php
                    if ($logged) {
                        ?>
                        <h1 class="fw-light">Your Galeries</h1>
                        <p class="lead text-body-secondary">This is where all your galleries ar bieng displayed.
                        </p>
                        <a href="createGallery.php" class="btn btn-success">Add New</a>
                        <?php
                    } else {
                        ?>
                        <h1 class="fw-light">All Galeries</h1>
                        <p class="lead text-body-secondary">This is where all of the websites galleries ar bieng displayed.
                        </p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-warning">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php } ?>

        <div class="album py-5 bg-body-tertiary">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                    <?php if ($gallerys != 0) {
                        # code...
                        foreach ($gallerys as $gallery) {
                            $image = getImageByGalleryId($conn, $gallery['galleryId']);
                            ?>

                            <div class="col">
                                <div class="card shadow-sm">
                                    <?php
                                    if ($image != 0) { ?>
                                        <img src="uploads/<?= $image['imageURL'] ?>" class="card-img-top" alt="...">
                                    <?php } else { ?>
                                        <img src="uploads/default-image.jpg" class="card-img-top" alt="...">
                                    <?php } ?>
                                    <div class="card-body">
                                        <p class="card-text">
                                            <?= $gallery['title'] ?>
                                        </p>
                                        <p class="card-text">
                                            <?php
                                            if ($logged) {
                                                if ($gallery['published'] == 1) {
                                                    echo "State: Public";
                                                } else if ($gallery['published'] == 0) {
                                                    echo "State: Private";
                                                } else {
                                                    echo "State: ERROR";
                                                }
                                            }
                                            ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a href="viewGallery.php?galleryId=<?= $gallery['galleryId'] ?>"
                                                    class="btn btn-sm btn-outline-secondary">View</a>
                                                <?php
                                                if ($logged) { ?>

                                                    <a href="editGallery.php?galleryId=<?= $gallery['galleryId'] ?>"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <button data-id="<?= $gallery['galleryId'] ?>" type="button"
                                                        data-bs-toggle="modal" data-bs-target="#confirmation"
                                                        class="btn btn-danger btn-sm delete-button">Delete</button>
                                                <?php } ?>
                                            </div>
                                            <?php if ($logged) { ?>
                                                <div>
                                                    <?php
                                                    if ($gallery['published'] == 1) {
                                                        ?>
                                                        <a href="req/publishGallery.php?galleryId=<?= $gallery['galleryId'] ?>&publish=1"
                                                            class="btn btn-link disabled">Public</a>
                                                        <a href="req/publishGallery.php?galleryId=<?= $gallery['galleryId'] ?>&publish=0"
                                                            class="btn btn-link ">Private</a>
                                                    <?php } else { ?>
                                                        <a href="req/publishGallery.php?galleryId=<?= $gallery['galleryId'] ?>&publish=1"
                                                            class="btn btn-link ">Public</a>
                                                        <a href="req/publishGallery.php?galleryId=<?= $gallery['galleryId'] ?>&publish=0"
                                                            class="btn btn-link disabled">Private</a>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="alert alert-warning">
                            Empty!
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </main>

    <footer class="text-body-secondary py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
        </div>
    </footer>

    <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm deletion of gallery</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Deleting the gallery will delete all of the templates and images
                    associated with the gallery.
                    Are you sure you want to continue?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a data-id="" class="btn btn-danger confirm-delete">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.delete-button').on('click', function (e) {
            var id = $(this).attr('data-id');
            $('.confirm-delete').attr('data-id', id);

        });
        $(".confirm-delete").on('click', function (e) {
            var id = $(this).attr('data-id');
            console.log(id);
            location.href = "req/deleteGallery.php?galleryId=" + id;
        });
    </script>

</body>

</html>