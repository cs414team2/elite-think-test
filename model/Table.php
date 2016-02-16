<?php
	class Table {
		private $table_name;
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		public function get_table($table) {
			$db = $this->prepare_connection();
			
			$statement = $db->query("SELECT * FROM " . $table);
			
			if($statement->num_rows > 0){
				while($student = $statement->fetch_row()){
					echo "<tr " . "id='" . $student[0] . "'>";
					foreach($student as $student_col) {
					  echo "<td>" . $student_col . "</td>";
					}
					echo "</tr>";
				}
			}
			else{
				echo "<tr> <td> No Students </td> </tr>";
			}
		}
	}
?>