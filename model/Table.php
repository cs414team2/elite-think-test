<?php
	class Table {
		const IS_ACTIVE = "is_active";
		
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
						echo "<tr " . "id='" . $record[$table . "_id"] . "' class='". $table . "_record, " . $record[self::IS_ACTIVE]."'>";
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