<?php
session_start();

$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Admin - Users</title>
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
        include_once("../data/User.php");
        include_once("../db_conn.php");
        $users = getAllUserDeep($conn);

        ?>

        <div class="py-5 text-center container">
            <h3 class="mb-3">All Users</h3>
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

            <?php if ($users != 0) { ?>
                <table class="table t1 table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Last changed</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <th scope="row">
                                    <?= $user['userId'] ?>
                                </th>
                                <td>
                                    <?= $user['username'] ?>
                                </td>
                                <td>
                                    <?= $user['timestamp'] ?>
                                </td>
                                <td>
                                    <button data-id="<?= $user['userId'] ?>" type="button" data-bs-toggle="modal"
                                        data-bs-target="#confirmation" class="btn btn-danger btn-sm delete-button"
                                        style="margin-left: 10px;">Delete</button>
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

        <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm deletion of user</h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Deleting the user will delete all of the galleries, templates and images associated with the user.
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
                location.href = "req/deleteUser.php?id=" + id;
            });
        </script>

    </body>

    </html>

<?php } else {
    header("Location: ../admiLogin.php");
    exit;
} ?>