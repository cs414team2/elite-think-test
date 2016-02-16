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
				while($record = $statement->fetch_row()){
					echo "<tr " . "id='" . $row[0] . "'>";
					foreach($record as $record_col) {
					  echo "<td>" . $record_col . "</td>";
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