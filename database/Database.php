<?
class Database {
	private $host = "mysql";
	private $username = "praktikum";
	private $password = "praktikum123";
	private $dbname = "praktikum";
	private $koneksi;
	
	function __construct(){
		$this->koneksi = new mysqli($this->host, $this->username, $this->password, $this->dbname);
		if ( $this->koneksi->connect_errno ) {
			echo "Gagal terhubung ke database mysql! ".$this->koneksi->connect_errno;
		}
	}
	public function getKoneksi() {
		return $this->koneksi;
	}
}