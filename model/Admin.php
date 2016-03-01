<?php
    // Represents an EliteThink administrator
	class Admin {
		
		const IS_ACTIVE = "is_active";
		
		// Position of data in the array
		const TEACHER_ID    = 0;
		const TEACHER_LNAME = 1;
		const TEACHER_FNAME = 2;
		
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
		
		public function get_students()
			$db = $this->prepare_connection();
			$statement = $db->query("SELECT student_id, student_lname, student_fname FROM student");
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch_assoc()){
					{
						echo "<tr " . "id='" . $record["student_id"] . "' class='student_record, " . $record[self::IS_ACTIVE]."'>";
						echo "<td><input type='checkbox'></td>" 	
						foreach($record as $col_name => $col_data) {
						  if($col_name != self::IS_ACTIVE)
							echo "<td class='clickable_row'>" . $col_data . "</td>";
						}
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