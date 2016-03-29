<?php
class Course{
	
	private $id;
	private $elite_db_connection;
	private $name;
	private $number;
	
	public function __construct($class_id){
		$this->id = $class_id;
		$this->elite_db_connection = $this->prepare_connection();
		
		
		$statement = $this->elite_db_connection->prepare("SELECT class_name, class_number
		                                         FROM class
												 WHERE class_id = ?") ;
		$statement->bind_param("i", $this->id) 				        or die($statement->error);
		$statement->execute() 									    or die($statement->error);
		$statement->bind_result($class_name, $class_number) 		or die($statement->error);
		$statement->fetch();
		$this->name = $class_name;
		$this->number = $class_number;
	}
	
	private function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	public function get_class_name(){
		return $this->name;
	}
	
	public function get_class_number(){
		return $this->number;
	}

}
?>