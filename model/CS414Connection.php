<?php 
class CS414Connection {
	
	private $database_connection;
	
	public function __construct() {
		$this->database_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($db->error);
	}
	
	public function getConnection() {
		return $this->database_connection;
	}
}
?>