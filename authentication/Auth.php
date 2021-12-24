<?
class Auth {
	private $db;
	private $error;
	private $isLoggedIn;

	function __construct($connection) {
		$this->db = $connection;
		session_start();
	}

	public function login($username, $password, $remember=false) {
		$statem = $this->db->prepare("SELECT * FROM users WHERE username = ?");
		$statem->bind_param("s",$username);
		$statem->execute();
		$result = $statem->get_result();
		if ($result->num_rows === 1) {
			$akun_di_database = $result->fetch_assoc();
			if (password_verify($password,$akun_di_database["password"])) {
				// login success
				$_SESSION['user_session'] = $akun_di_database['uid'];
				return true;
			}
		}
		$this->error = "Username atau Password salah!";
		return false;
	}
	
	public function logout() {
		unset($_SESSION['user_session']);
		session_unset();
		session_destroy();
		return true;
	}
	
	public function register($username, $password) {
		$statem = $this->db->prepare("SELECT * FROM users WHERE username = ?");
		$statem->bind_param("s",$username);
		$statem->execute();
		$result = $statem->get_result();
		if ($result->fetch_assoc()) { // jika username telah diambil
			$this->error = "Username telah diambil!";
			return false;
		} else {
			// jika username belum ada di db
			// mencoba masukkan ke db, tapi hash dulu passwordnya biar aman
			$password = password_hash($password, PASSWORD_DEFAULT);
			$statem = $this->db->prepare("INSERT INTO users (username,password) VALUES (?,?)");
			$statem->bind_param("ss",$username,$password);
			$result = $statem->execute();
			//if ($result->affected_rows() > 0) { // bakal error [Fatal error: Uncaught Error: Call to a member function affected_rows() on bool]
			// menurut dokumentasi php resmi, affected_rows hanya ada di class mysqli::$affected_rows
			// karena class mysqli_stmt tidak mengenali affected_rows
			// gunakan langsung:
			if ($this->db->affected_rows > 0) {
				return true; // input akun baru berhasil
			} //https://forum.codeigniter.com/thread-23372.html
			// https://www.php.net/manual/en/book.mysqli.php
		}
		return false;
	}

	public function isLoggedIn() {
		if (isset($_SESSION['user_session'])) {
			return true;
		}
		return false;
	}

	public function getUser() {

		if (!$this->isLoggedIn()) {
			return false;
		}

		$statem = $this->db->prepare("SELECT * FROM users WHERE uid = ?");
		$statem->bind_param("s",$_SESSION['user_session']);
		$statem->execute();
		$result = $statem->get_result();
		return $result;
		// lanjut
	}
	
	public function getLastError() {
		return $this->error;
	}
	// Referensi:
	// https://qadrlabs.com/post/belajar-php-oop-part-14-membuat-login-dan-register-sistem
}