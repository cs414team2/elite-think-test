<?php
	class Session {
		// Access level constants
		const UNAUTHENTICATED = 0;
		const ADMINISTRATOR = 1;
		const TEACHER = 2;
		const STUDENT = 3;
		
		private $access_level;
		private $user_id;
		private $password;
		private $first_name;
		private $last_name;
		
		public function __construct($id, $pass) {
			$pass = htmlspecialchars($pass);
			$db = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");

			// Runs database authentication function and returns access level
			$statement = $db->prepare("SELECT authenticate_user(?, ?)"); 
			$statement->bind_param("is", $id, $pass) or die($statement->error);
			$statement->execute() or die($statement->error);
			$statement->bind_result($authentication_level) or die($statement->error);
			$statement->fetch() or die($statement->error);
			$statement->close();
			
			$this->access_level = $authentication_level;
			
			if ($this->access_level > self::UNAUTHENTICATED)
			{
				$this->user_id = $id;
				$this->password = $pass;
				
				$name_statement = $db->prepare("SELECT get_fname(?)") or die($db->error); 
				$name_statement->bind_param("i", $this->user_id) or die($name_statement->error); 
				$name_statement->execute() or die($name_statement->error);
				$name_statement->bind_result($first_name) or die($name_statement->error);
				$name_statement->fetch() or die($name_statement->error);
				$this->first_name = $first_name;
				$name_statement->close();
				$name_statement = $db->prepare("SELECT get_lname(?)") or die($db->error); 
				$name_statement->bind_param("i", $this->user_id) or die($name_statement->error); 
				$name_statement->execute() or die($name_statement->error);
				$name_statement->bind_result($last_name) or die($name_statement->error);
				$name_statement->fetch() or die($name_statement->error);
				$this->last_name = $last_name;
			}
		}
		
		//Getters and Setters
		public function get_user_id() {
			return ((int)$this->user_id);
		}
		
		public function get_access_level() {
			return $this->access_level;
		}
		
		public function get_first_name() {
			return $this->first_name;
		}
		
		public function get_last_name() {
			return $this->last_name;
		}
		
		public function is_authenticated() {
			return $this->access_level > self::UNAUTHENTICATED ? true : false;
		}
		
		public function is_admin() {
			return $this->access_level == self::ADMINISTRATOR ? true : false;
		}
		public function is_teacher() {
			return $this->access_level == self::TEACHER ? true : false;
		}
		public function is_student() {
			return $this->access_level == self::STUDENT ? true : false;
		}
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");	
		}
	}
?>