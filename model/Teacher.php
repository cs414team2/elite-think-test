<?php
	class Teacher {
		private $teacher_id;
		
		public function __constructor($t_id){
			$this->teacher_id = $t_id;
		}
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		public function get_classes() {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name FROM class WHERE teacher_id = ?") or die($db->error);
			$statement->bind_param("i", $this->teacher_id);
			$statement->execute();
			
			if($statement->num_rows > 0){
				while($class = $statement->fetch_row()){
					echo "<tr " . "id='" . $class[0] . "'>";
					foreach($class as $class_col) {
					  echo "<td>" . $class_col . "</td>";
					}
					echo "</tr>";
				}
			}
			else{
				echo "<tr> <td> No Classes </td> </tr>";
			}
		}
	}
?>