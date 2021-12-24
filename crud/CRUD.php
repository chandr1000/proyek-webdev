<?
class CRUD {
	private $db;
	
	function __construct($connection) {
		$this->db = $connection;
	}
	
	public function viewBookmark($uid, $id=NULL) {
		if (isset($id)) {
			$statem = $this->db->prepare("SELECT * FROM bookmark WHERE ( id =? and uid =? )");
			$statem->bind_param("ii",$id,$uid);
			$statem->execute();
			$result = $statem->get_result();
		} else {
			$statem = $this->db->prepare("SELECT * FROM bookmark WHERE uid =?");
			$statem->bind_param("i",$uid);
			$statem->execute();
			$result = $statem->get_result(); // bakal selalu false jika bukan SELECT; refer ke link di bawah ini
		}
		return $result;
	}
	
	public function updateBookmark($title=NULL,$url=NULL,$id=NULL,$uid=NULL,$visited=NULL) {
		if (isset($visited)) {
			$statem = $this->db->prepare("UPDATE bookmark SET visited =? WHERE ( id =? and uid =? )");
			$statem->bind_param("iii",$visited,$id,$uid);
			$result = $statem->execute();
			return $result;
		}
		$statem = $this->db->prepare("UPDATE bookmark SET title =?, url =? WHERE ( id =? and uid =?)");
		$statem->bind_param("ssii",$title,$url,$id,$uid);
		$result = $statem->execute();
		// $result = $statem->get_result();
		// https://stackoverflow.com/questions/40187821/prepare-statement-return-false-but-insert-successfully
		return $result;
	}
	
	public function deleteBookmark($uid,$id) {
		$statem = $this->db->prepare("DELETE FROM bookmark WHERE ( id =? and uid =? )");
		$statem->bind_param("ii",$id,$uid);
		$result = $statem->execute();
		return $result;
	}
	
	public function createBookmark($uid,$title,$url) {
		$statem = $this->db->prepare("INSERT INTO bookmark (`title`, `url`, `visited`, `uid`) VALUES (?,?,0,?)");
		$statem->bind_param("ssi",$title,$url,$uid);
		$result = $statem->execute();
		return $result;
	}
	// https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php
}