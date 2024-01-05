<?php

if (
	isset($_POST['uname']) &&
	isset($_POST['pass'])
) {

	include "../db_conn.php";
	include_once("../data/User.php");


	$uname = test_input($_POST['uname']);
	$pass = test_input($_POST['pass']);

	$data = "&uname=" . $uname;

	list($dbuname) = getAllUserByUsername($conn, $uname);

	if (empty($uname)) {
		$em = "User name is required";
		header("Location: ../signup.php?error=$em&$data");
		exit;
	} else if (empty($pass)) {
		$em = "Password is required";
		header("Location: ../signup.php?error=$em&$data");
		exit;
	} else if ($dbuname) {
		$em = "This user name already exists";
		header("Location: ../signup.php?error=$em&$data");
		exit;
	} else {

		// hashing the password
		$pass = password_hash($pass, PASSWORD_DEFAULT);


		$sql = "INSERT INTO vartotojas(username, password, userLevel) 
    	        VALUES(?,?,1)";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$uname, $pass]);

		header("Location: ../login.php?success=Your account has been created successfully");
		exit;
	}


} else {
	header("Location: ../signup.php?error=error");
	exit;
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }
