<?php
    // Represents an EliteThink administrator
	class Admin {
		
		const IS_ACTIVE = "is_active";
		
		// Position of data in the array
		const TEACHER_ID    = 0;
		const TEACHER_LNAME = 1;
		const TEACHER_FNAME = 2;
		const IS_ENROLLED   = 1;
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		// Prints out a table of teacher information
		public function get_teachers() {
			$db = $this->prepare_connection();
			$statement = $db->query("SELECT teacher_id, teacher_lname, teacher_fname FROM teacher");
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch_row()){
					echo "<option " . "value='" . $record[self::TEACHER_ID] . "'>";
					echo $record[self::TEACHER_ID] . " &nbsp;&nbsp;" . $record[self::TEACHER_LNAME] . ", " . $record[self::TEACHER_FNAME];
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