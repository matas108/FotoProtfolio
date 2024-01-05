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
	<title>Create Gallery</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

	<link rel="stylesheet" href="css/richtext.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.richtext.min.js"></script>

	<style>
		#errorMs {
			color: #a00;
		}
	</style>
</head>

<body>

	<?php
	include 'NavBar.php';
	?>
	<div class="py-5 text-center container">
		<h3 class="mb-3">Create New Gallery
			<a href="gallery.php" class="btn btn-success">Back to Galleries</a>
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
		<form class="shadow p-3" action="req/addGallery.php" method="post" enctype="multipart/form-data">

			<div class="container my-5">

				<label class="form-label">Title</label>
				<input type="text" class="form-control" name="title">

				<button type="submit" class="btn btn-primary ">Create</button>

			</div>
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
</body>

</html>