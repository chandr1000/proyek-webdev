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
$result = $bookmark_obj->deleteBookmark($uid,$id);

if ($result) {
    echo "<script>
        alert('Data berhasil dihapus!');
        document.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('Data gagal dihapus!');
        document.location.href = 'index.php';
    </script>";
}
