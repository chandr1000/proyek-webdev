<?php
require_once 'database/Database.php';
require_once 'crud/CRUD.php';
require_once 'authentication/Auth.php';

$bookmark_db = new Database();
$bookmark_obj = new CRUD($bookmark_db->getKoneksi());
$user = new Auth($bookmark_db->getKoneksi());

if (!$user->isLoggedIn()) {
	header("location: login.php");
	exit();
}

$uid = $user->getUser()->fetch_assoc()['uid'];

if (isset($_POST["submit"])) {
    $title = htmlspecialchars($_POST["title"]);
    $url = htmlspecialchars($_POST["url"]);

	$result = $bookmark_obj->createBookmark($uid,$title,$url);

    if ($result) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            document.location.href = 'create.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookmark: Create a new Bookmark</title>
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
		<h1>Menambah bookmark</h1>
	<form action="" method="post">
			<input type="text" name="title" id="title" required placeholder="Judul">
			
			<input type="text" name="url" id="url" required placeholder="Link">
			<input type="submit" name="submit">
	</form>
</div>
</body>

</html>