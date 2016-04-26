<?php
	class Table {
		const IS_ACTIVE = "is_active";
		
		private $table_name;
		private $show_inactive;
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		public function print_table($table) {
			$this->table_name = $table;
			$db = $this->prepare_connection();
			$statement = $db->query("SELECT * FROM " . $table . " ORDER BY ". $table ."_id DESC");
			
			if($statement->num_rows > 0){
				while($record = $statement->fetch_assoc()){
					{
						echo "<tr " . "id='" . $record[$table . "_id"] . "' class='clickable_row ". $table . "_record'>";
						foreach($record as $col_name => $col_data) {
						  if($col_name != self::IS_ACTIVE)
							echo "<td>" . $col_data . "</td>";
						}
						echo "</tr>\r\n";
					}
				}
			}
			else{
				echo "<tr> <td colspan='5' style='text-align: center;' >No Data </td></tr>";
			}
		}
	}
?>