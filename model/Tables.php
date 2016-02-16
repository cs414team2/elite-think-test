<?php
	class Tables {
		private $table_name
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
			
		}

		public function get_students($table) {
			$db = prepare_connection();
			
			$students = $db->query("SELECT * FROM " . $table);
			
			if($students->num_rows > 0){
				while($student = $students->fetch_assoc()){
					echo "<tr> <td>" . student["student_id"] . "</td>" .
						  "<td>" . student["student_lname"].", " . 
						           student["student_fname"] . "</td>" .
						  "<td>" . student["student_email"] . "</td>" .
						  "<td>" . student["student_password"] . "</td> </tr>";
				}
			}
			else{
				echo "<tr> <td> No Students </td> </tr>"
			}
		}
	}
?>