<?php
	class Session {
		const UNAUTHENTICATED = 0;
		const ADMINISTRATOR = 1;
		const TEACHER = 2;
		const STUDENT = 3;
		
		private $access_level;
		private $user_id;
		private $password;
		
		public function __construct() {
			$access_level = UNAUTHENTICATED;
		}
		public function __construct($id, $pass) {
			$user_id = $id;
			$password = $password;
			$access_level = UNAUTHENTICATED;
		}
		
		public function authenticate_user() {
			$db = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
			
			//temporary testing code
			$access_level = 1;
		}
		
		public function get_user_id() {
			return $user_id;
		}
	}
?>