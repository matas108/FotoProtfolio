<?php
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - galleries</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    include 'NavBar.php';
    include_once("data/Template.php");
    include_once("db_conn.php");
    $galleryId =  $_GET['galleryId'];
    $templates = getByGalleryId($conn, $galleryId);
    ?>

    <div class="py-5 text-center container">
        <h3 class="mb-3">Edit gallery 
            <a href="createTemplate.php?galleryId=<?= $galleryId ?>" class="btn btn-success">Add New</a>
        </h3>
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

        <?php if ($templates != 0) { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($templates as $template) {
                        ?>
                        <tr>
                            <th scope="row">
                                <?= $template['templateId'] ?>
                            </th>
                            <td>
                                <?php if ($template['sablonoTipas'] == 1) {
                                    echo "Vertical";
                                } else if ($template['sablonoTipas'] == 2) {
                                    echo "Horizontal";
                                } else {
                                    echo "ERROR";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="req/deleteTemplate.php?templateId=<?= $template['templateId'] ?>" class="btn btn-danger">Delete</a>
                                <a href="editTemplate.php?templateId=<?= $template['templateId'] ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

        <?php } else { ?>
            <div class="alert alert-warning">
                Empty!
            </div>
        <?php } ?>
    </div>
    </section>
    </div>

    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>