<?php
	class Teacher {
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		public function get_classes($teacher_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name FROM class WHERE teacher_id = ?") or die($db->error);
			$statement->bind_param("i", $teacher_id);
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
		public function get_classes_dropdown($teacher_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name FROM class WHERE teacher_id = ?") or die($db->error);
			$statement->bind_param("i", $teacher_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_id, $class_number, $class_name);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<option " . "value='" . $class_id . "'>";
					echo $class_number . ", " . $class_name;
					echo "</option>";
				}
			}
			else{
				echo "<option>" . $teacher_id. " </option>";
			}
		}
	}
?>