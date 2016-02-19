<?php
	class Admin {
		const TEACHER_ID    = 0;
		const TEACHER_LNAME = 1;
		const TEACHER_FNAME = 2;
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		public function get_teachers() {
			$db = $this->prepare_connection();
			$statement = $db->query("SELECT teacher_id, teacher_lname, teacher_fname FROM teacher");
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch_row()){
					echo "<option " . "value='" . $record[self::TEACHER_ID] . "'>";
					echo $record[self::TEACHER_ID] . " &nbsp;&nbsp;" . $record[self::TEACHER_LNAME] . ", " . $record[self::TEACHER_FNAME];
					echo "</option>";
				}
			}
			else{
				echo "<tr> <td> No Teachers </td> </tr>";
			}
		}
	}
?>