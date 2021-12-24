<?
require_once 'database/Database.php';
require_once 'authentication/Auth.php';

$db = new Database();
$user = new Auth($db->getKoneksi());

if (!$user->isLoggedIn()) { // jika belum login
	header("location: login.php");
	exit();
} else { // jika sudah login tapi hendak logout
	$user->logout();
	header("location: login.php");
	exit();
}
