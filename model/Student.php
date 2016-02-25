<?php
	class Tests {
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		public function print_classes($student_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_number, class_name, is_active, class_id
			                           FROM student_classes
									   WHERE student_id = ? AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_number, $class_name, $is_active, $class_id);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<tr " . "id='" . $class_id . "'>";
					echo "<td>" . $class_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "</tr>";
				}
			}
			else{
				echo "<tr> <td colspan='2'> No Classes </td> </tr>";
			}
		}
		
		public function print_classes_dropdown($student_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name 
			                           FROM student_classes 
									   WHERE student_id = ? AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $student_id);
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
				echo "<option>" . $student_id. " </option>";
			}
		}
		public function print_tests($student_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name 
			                           FROM student_tests 
									   WHERE student_id = ? AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_id, $class_number, $class_name);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<tr " . "id='" . $class_id . "'>";
					echo "<td>" . $class_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "</tr>";
				}
			}
			else{
				echo "<tr> <td colspan='2'> No Classes </td> </tr>";
			}
		}
	}
?>