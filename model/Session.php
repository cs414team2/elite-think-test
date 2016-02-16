<?php
	class Session {
		const UNAUTHENTICATED = 0;
		const ADMINISTRATOR = 1;
		const TEACHER = 2;
		const STUDENT = 3;
		
		private $access_level;
		private $user_id;
		private $password;
		
		public function __construct($id, $pass) {
			$db = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
			$statement = $db->prepare("SELECT authenticate_user(?, ?)"); 
			$statement->bind_param("is", $id, $pass);
			$statement->execute();
			$statement->bind_result($authentication_level);
			$statement->fetch();
			
			$this->access_level = $authentication_level;
			
			if ($this->access_level > self::UNAUTHENTICATED)
			{
				$this->user_id = $id;
				$this->password = $pass;
			}
		}
		
		public function get_user_id() {
			return $this->user_id;
		}
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
			
		}
		
		public function is_authenticated() {
			return $this->access_level > self::UNAUTHENTICATED ? true : false;
		}
		
		public function get_access_level() {
			return $this->access_level;
		}
		
		public function get_user_name() {
			$db = prepare_connection();
						
			$statement = $db->prepare("SELECT get_fname(?)") or die($db->error); 
			$statement->bind_param("i", $this->user_id);
			$statement->execute();
			$statement->bind_result($first_name);
			$statement->fetch();

			return $first_name;
		}
	}
?>