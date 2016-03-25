<?php
    // Represents an EliteThink administrator
	class Admin {
		
		const IS_ACTIVE = "is_active";
		const IS_ENROLLED   = 1;
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		// Prints out a table of teacher information
		public function get_teachers() {
			$db = $this->prepare_connection();
			$statement = $db->query("SELECT teacher_id, teacher_lname, teacher_fname 
			                         FROM teacher
									 ORDER BY teacher_id DESC");
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch_assoc()){
					echo "<option " . "value='" . $record['teacher_id'] . "'>";
					echo $record['teacher_id'] . " &nbsp;&nbsp;" . $record['teacher_lname'] . ", " . $record['teacher_fname'];
					echo "</option>\r\n";
				}
			}
			else{
				echo "<tr> <td> No Teachers </td> </tr>";
			}
		}
		
		// Prints out a drop down list of teachers and selects the one teaching a given class.
		public function get_teacher_ddl($class_id) {
			$db = $this->prepare_connection();
			
			$class_statement = $db->prepare("SELECT teacher_id FROM class WHERE class_id = ?");
			$class_statement->bind_param("i", $class_id);
			$class_statement->bind_result($teacher_id);
			$class_statement->execute();
			$class_statement->fetch();
			echo "<option value='null' " . ($class_statement->num_rows > 0 ? "selected='selected'" : " ") . ">- No teacher assigned -</option>";
			$class_statement->close();
			
			$teacher_statement = $db->query("SELECT teacher_id, teacher_lname, teacher_fname FROM teacher");
			
			if($teacher_statement->num_rows > 0){
				while($record = $teacher_statement->fetch_assoc()){
					echo "<option " . "value='" . $record['teacher_id'] . "' ". ($teacher_id == $record['teacher_id'] ? "selected='selected'" : " ") . ">";
					echo $record['teacher_id'] . " &nbsp;&nbsp;" . $record['teacher_lname'] . ", " . $record['teacher_fname'];
					echo "</option>\r\n";
				}
			}
			else{
				echo "<tr> <td> No Teachers </td> </tr>";
			}
		}
		
		public function get_students($c_id){
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT student_id,
											  student_lname,
											  student_fname,
											  is_active,
											  is_enrolled(student_id, ?) as enrolled
									   FROM   student
									   ORDER BY enrolled DESC");
			$statement->bind_param("i", $c_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($student_id, $student_lname, $student_fname, $is_active, $is_enrolled);
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch()){
					{
						$is_enrolled == self::IS_ENROLLED ? $is_enrolled = "checked" : $is_enrolled = "";
						echo "<tr class='clickable_row'" . "id='" . $student_id . "' class='student_record, " . $is_active."'>";
						echo "<td>
								<input type='checkbox' id='student_".$student_id."' ". $is_enrolled .">
								<label for='student_".$student_id."'>Add</label>
							  </td>";
						echo "<td>" . $student_id . "</td>";
						echo "<td>" . $student_lname . "</td>";
						echo "<td>" . $student_fname . "</td>";
						echo "</tr>\r\n";
					}
				}
			}
			else{
				echo "<tr> <td> No " . $table_name . "s </td> </tr>";
			}
		}
	}
?>