<?php
require_once 'database/Database.php';
require_once 'crud/CRUD.php';
require_once 'authentication/Auth.php';

$bookmark_db = new Database();
$bookmark = new CRUD($bookmark_db->getKoneksi());
$user = new Auth($bookmark_db->getKoneksi());

//$bookmark = bookmarks->viewBookmark();

//$bookmark = $read_bookmark->getData();
//var_dump($bookmark);
//echo $bookmark['title'];

if (!$user->isLoggedIn()) {
	header("location: login.php");
	exit();
}

$uid = $user->getUser()->fetch_assoc()['uid'];
//echo($test->fetch_assoc()['uid']);
//echo($uid);

$date = new DateTime();
$date->setTimezone(new DateTimeZone('Asia/Makassar'));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookmark: Home</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</head>

<body>
    <header class="p-3 bg-dark text-white">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li>
              <a href="#" class="nav-link px-2 <? if ( ( !empty($page) || !isset($page) ) ) { echo 'text-white'; } ?> text-secondary">Aplikasi Bookmark</a>
            </li>
			<li>
				<a href="logout.php" class="nav-link px-2 text-secondary">Logout</a>
			</li>
          </ul>
          <ul class="nav col-0 col-lg-auto  mb-2 justify-content-center mb-md-0">
            <li class="px-2"><?= $date->format('l, d M Y') ?></li>
          </ul>
        </div>
      </div>
    </header>
	<main>
		<div class="container">
			<br />
			<div class="shadow p-3 mb-5 bg-body rounded">
				<div class="row align-items-start">
					<h3>Daftar bookmark ku</h3>
					<span class="border"></span>
					<br/>
					<table class="table table-striped">
								
								<tbody>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Judul</th>
										<th scope="col">Telah dikunjungi</th>
										<th scope="col">Action</th>
									</tr>
								<? $i = 1; ?>
								<? foreach ($bookmark->viewBookmark($uid) as $bm) : ?>
								<tr>
									<td><?= $i; ?></td>
									<td><a href="visit.php?id=<?= $bm["id"]; ?>" target="_blank"><?= $bm["title"]; ?></a></td>
									<td><?= $bm["visited"]; ?></td>
									<td>
										<button id="edit-<?= $bm["id"]; ?>" class="btn btn-warning">Edit</button></a>
										<script>$("#edit-<?= $bm["id"]; ?>").click(function() {
											$('#modal-edit').load('update.php?id=<?= $bm["id"]; ?>', function() {
												$('#modal-edit').modal('show');
												// load modal dari update.php setelah diklik, lalu buka modal jika sukses.
												// https://api.jquery.com/load/
												// https://api.jquery.com/click/
												// https://stackoverflow.com/questions/13183630/how-to-open-a-bootstrap-modal-window-using-jquery
											});
										});</script>
										<a href="delete.php?id=<?= $bm["id"]; ?>"><button class="btn btn-danger">Delete</button></a>
									</td>
								</tr>
								<? $i++; ?>
								<? endforeach; ?>
								</tbody>
					</table>
					<br>
				</div>
				<button type="button" class="btn btn-primary btn-end" data-bs-toggle="modal" data-bs-target="#modal-new">Tambahkan Bookmark</button>
			</div>
		</div>
	</main>
	<? include 'modal-new.html'; ?>
	<div class="modal" tabindex="-1" id="modal-edit">
	</div>
</body>

</html>