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
	<title>Create Template</title>
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

		.temp img {
			width: 300px;
		}
	</style>
</head>

<body>

	<?php
	include 'NavBar.php';
	include_once("data/TemplateType.php");
	include_once("db_conn.php");
	$galleryId = $_GET['galleryId'];
	$types = getAllTypes($conn);
	?>
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
	<form class="shadow p-3" action="req/addTemplate.php?galleryId=<?= $galleryId ?>" method="post"
		enctype="multipart/form-data">
		<div class="mb-3">
			<label class="form-label">Type</label>
			<select name="type" class="form-control">
				<?php foreach ($types as $type) { ?>
					<option value="<?= $type['sablonoTipasId'] ?>">
						<?= $type['name'] ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="container my-5">

			<div class="row row-cols-2 justify-content-center align-items-center">
				<div class="col-6">

					<input type="file" class="form-control" name="image1" id="image1">
					<div id="preview1"></div>

					<!-- <div class="temp">
						<img src="uploads/default-image.jpg" class="mx-auto d-block" id="preImg1">
					</div> -->
				</div>
				<div class="col-6 ">
					<label class="form-label">Photo description</label>
					<textarea class="form-control text" name="text1"></textarea>
				</div>



				<div class="col-6">

					<input type="file" class="form-control" name="image2" id="image2">
					<div id="preview2"></div>

					<!-- <div class="temp">
						<img src="uploads/default-image.jpg" class="mx-auto d-block" id="preImg2">
					</div> -->
				</div>

				<div class="col-6 ">
					<label class="form-label">Photo description</label>
					<textarea class="form-control text" name="text2"></textarea>
				</div>



				<div class="col-6">

					<input type="file" class="form-control" name="image3" id="image3">
					<div id="preview3"></div>

					<!-- <div class="temp">
						<img src="uploads/default-image.jpg" class="mx-auto d-block" id="preImg3">
					</div> -->
				</div>
				<div class="col-6 ">
					<label class="form-label">Photo description</label>
					<textarea class="form-control text" name="text3"></textarea>
				</div>

			</div>
			<button type="submit" class="btn btn-primary my-5">Create</button>

		</div>
	</form>

	<script>
		function imagePreview(fileInput, prieviewName) {
			if (fileInput.files && fileInput.files[0]) {
				var fileReader = new FileReader();
				fileReader.onload = function (event) {
					$(prieviewName).html('<img src="' + event.target.result + '" class="mx-auto d-block" />');
				};
				fileReader.readAsDataURL(fileInput.files[0]);
			}
		}

		$("#image1").change(function () {
			imagePreview(this, '#preview1');
		});
		$("#image2").change(function () {
			imagePreview(this, '#preview2');
		});
		$("#image3").change(function () {
			imagePreview(this, '#preview3');
		});
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
</body>

</html>