<?php
	class Table {
		private $table_name;
		private $show_inactive;
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		public function print_table($table) {
			$db = $this->prepare_connection();
			$statement = $db->query("SELECT * FROM " . $table);
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch_assoc()){
					{
						echo "<tr " . "id='" . $record[$table . "_id"] . "' class='". $table . "_record, " . $record["is_active"]."'>";
						foreach($record as $record_col) {
						  echo "<td>" . $record_col . "</td>";
						}
						echo "</tr>";
					}
				}
			}
			else{
				echo "<tr> <td> No Students </td> </tr>";
			}
		}
	}
?>