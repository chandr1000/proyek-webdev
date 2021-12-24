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

$id = $_GET["id"];
$uid = $user->getUser()->fetch_assoc()['uid'];
$bookmark = $bookmark_obj->viewBookmark($uid, $id)->fetch_assoc();

if (!isset($bookmark)) {
	echo "<h1>Bookmark tidak ketemu!</h1>
	<meta http-equiv=\"refresh\" content=\"3;url=index.php\" />";
	exit();
}

if (isset($_POST["submit"])) {
    $title = htmlspecialchars($_POST["title"]);
    $url = htmlspecialchars($_POST["url"]);

	$result = $bookmark_obj->updateBookmark($title,$url,$id,$uid);

    if ($result) {
        echo "<script>
            alert('Data berhasil diupdate!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diupdate!');
            document.location.href = 'update.php?id=".$id."';
        </script>";
    }
}
?>

  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">Ubah Bookmark</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <form action="update.php?id=<?= $id ?>" method="post">
		  <div class="modal-body">
			<div class="mb-3">
				<label for="title" class="form-label">Judul</label>
				<input class="form-text" value="<?= $bookmark["title"]; ?>" name="title" id="title" required>
			</div>
			<div class="mb-3">
				<label for="url" class="form-label">URL</label>
				<input class="form-text" value="<?= $bookmark["url"]; ?>" name="url" id="url" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" name="submit" class="btn btn-primary">Save changes</button>
		  </div>
	  </form>
	</div>
  </div>