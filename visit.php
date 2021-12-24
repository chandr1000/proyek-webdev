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
$id = $_GET["id"];
$bookmark = $bookmark_obj->viewBookmark($uid,$id)->fetch_assoc();

?>
<html>
<head>
<? 
if (!empty($bookmark)) {
	echo "<meta http-equiv=\"refresh\" content=\"3;url=".$bookmark['url']."\" /> ";
} ?>
</head>
<body>
<?
if (!empty($bookmark)) {
	$updatevisit = $bookmark['visited'] + 1;
	$bookmark_obj->updateBookmark(NULL,NULL,$id,$uid,$updatevisit);
	echo "<h1>Redirecting...</h1>";
	echo "<br>klik link di bawah jika gagal redirect<br>";
	echo "<a href=\"".$bookmark['url']."\">".$bookmark['url']."</a>";
} else {
	echo "<h1>Gagal melakukan redirect!</h1>";
}
?>
</body>
</html>