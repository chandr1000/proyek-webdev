<?php
require_once 'database/Database.php';
require_once 'authentication/Auth.php';

$db = new Database();
$user = new Auth($db->getKoneksi());

if ($user->isLoggedIn()) {
	header("location: index.php");
	exit();
}

if (isset($_POST["submit"])) {
    //$title = htmlspecialchars($_POST["title"]);
    //$url = htmlspecialchars($_POST["url"]);
	$username = htmlspecialchars($_POST["username"]);
	$password = htmlspecialchars($_POST["password"]);
	$cpassword = htmlspecialchars($_POST["cpassword"]);
	
	if ($password === $cpassword) {
		if ($user->register($username, $password)) {
			// sukses
			echo "<h1>Pendaftaran sukses!</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=login.php\" />";
			exit();
		} else {
			echo "<h1>".$user->getLastError()."</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=register.php\" />";
			exit();
		}
	}
}
// kode bawah ini udah usang, ini pas masih pake procedural

if (isset($_POST["submit"])) {
    //$title = htmlspecialchars($_POST["title"]);
    //$url = htmlspecialchars($_POST["url"]);
	$username = $_POST["username"];
	$password = $_POST["password"];
	$cpassword = $_POST["cpassword"];
	
	if ($password === $cpassword) {
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$password = mysqli_real_escape_string($conn, $_POST["password"]);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$get_usern = "SELECT * FROM users WHERE username = '$username'";
		$check_usern = mysqli_query($conn, $get_usern);
		//die(var_dump($check_usern));
		if (mysqli_fetch_assoc($check_usern)) {
			echo "<h1>Username sudah diambil!</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=\"register.php\" />";
			exit();
		} else {
			$insert_sql = "INSERT INTO users (username,password) VALUES ('$username','$password');";
			mysqli_query($conn, $insert_sql);
			
			if (mysqli_affected_rows($conn) > 0) {
				echo "<h1>Pendaftaran sukses!</h1>
				<meta http-equiv=\"refresh\" content=\"3;url=\"login.php\" />";
				exit();
			} else {
				echo "<h1>Pendaftaran gagal!</h1>
				<meta http-equiv=\"refresh\" content=\"3;url=\"register.php\" />";
				exit();
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookmark: Daftar Akun</title>
	<style type="text/css">
	.form-style-6{
		font: 95% Arial, Helvetica, sans-serif;
		max-width: 400px;
		margin: 10px auto;
		padding: 16px;
		background: #F7F7F7;
	}
	.form-style-6 h1{
		background: #43D1AF;
		padding: 20px 0;
		font-size: 140%;
		font-weight: 300;
		text-align: center;
		color: #fff;
		margin: -16px -16px 16px -16px;
	}
	.form-style-6 input[type="text"],
	.form-style-6 input[type="date"],
	.form-style-6 input[type="datetime"],
	.form-style-6 input[type="email"],
	.form-style-6 input[type="number"],
	.form-style-6 input[type="search"],
	.form-style-6 input[type="time"],
	.form-style-6 input[type="url"],
	.form-style-6 input[type="password"],
	.form-style-6 textarea,
	.form-style-6 select 
	{
		-webkit-transition: all 0.30s ease-in-out;
		-moz-transition: all 0.30s ease-in-out;
		-ms-transition: all 0.30s ease-in-out;
		-o-transition: all 0.30s ease-in-out;
		outline: none;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		width: 100%;
		background: #fff;
		margin-bottom: 4%;
		border: 1px solid #ccc;
		padding: 3%;
		color: #555;
		font: 95% Arial, Helvetica, sans-serif;
	}
	.form-style-6 input[type="text"]:focus,
	.form-style-6 input[type="date"]:focus,
	.form-style-6 input[type="datetime"]:focus,
	.form-style-6 input[type="email"]:focus,
	.form-style-6 input[type="number"]:focus,
	.form-style-6 input[type="search"]:focus,
	.form-style-6 input[type="time"]:focus,
	.form-style-6 input[type="url"]:focus,
	.form-style-6 input[type="password"]:focus,
	.form-style-6 textarea:focus,
	.form-style-6 select:focus
	{
		box-shadow: 0 0 5px #43D1AF;
		padding: 3%;
		border: 1px solid #43D1AF;
	}

	.form-style-6 input[type="submit"],
	.form-style-6 input[type="button"]{
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		width: 100%;
		padding: 3%;
		background: #43D1AF;
		border-bottom: 2px solid #30C29E;
		border-top-style: none;
		border-right-style: none;
		border-left-style: none;	
		color: #fff;
	}
	.form-style-6 input[type="submit"]:hover,
	.form-style-6 input[type="button"]:hover{
		background: #2EBC99;
	}
	</style>
</head>

<body>
	<div class="form-style-6">
		<h1>Register a New Account</h1>
	<form action="" method="post">
			<input type="text" name="username" id="username" required placeholder="Username">
			
			<input type="password" name="password" id="password" required placeholder="Password">
			<input type="password" name="cpassword" id="cpassword" required placeholder="Konfirmasi Password">
			<input type="submit" name="submit">
	</form>
</body>

</html>