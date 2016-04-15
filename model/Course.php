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
	
	
	// Getters and Setters
	public function get_class_name(){
		return $this->name;
	}
	
	public function get_class_number(){
		return $this->number;
	}
	
	// Print the enrolled students
	public function print_students(){
		$student_statement = $this->elite_db_connection->prepare('SELECT s.student_id, s.student_fname, s.student_lname, s.student_email,
																		(SELECT ROUND(AVG(scg.grade), 2)
											                               FROM student_class_grades scg
											                              WHERE scg.student_id = s.student_id AND scg.class_id = ?) as grade
		                                                            FROM enrollment e
																	JOIN student s ON s.student_id = e.student_id
																   WHERE e.class_id = ?
																   ORDER BY s.student_lname, s.student_fname');
		$student_statement->bind_param('ii', $this->id, $this->id);
		$student_statement->bind_result($student_id, $student_first, $student_last, $student_email, $grade);
		$student_statement->execute();
		$student_statement->store_result();
		
		if($student_statement->num_rows > 0){
			while($student_statement->fetch()){
				echo "\r\n<tr>";
				echo "\r\n  <td>" . $student_id . "</td>";
				echo "\r\n  <td>" . $student_last . ", " . $student_first . "</td>";
				echo "\r\n  <td>" . $student_email . "</td>";
				echo "\r\n  <td>". $grade . ($grade != null ? "%" : "N/A") . "</td>";
				echo "\r\n</tr>";
			}
		}
		else {
			echo "\r\n<tr><td colspan='4'>No Students Enrolled</td></tr>";
		}
	}

}
?>