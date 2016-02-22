<?php
	require_once('TableNames.php');
	class Tests {
		private $table_type;
		
		public function _constructor($t_type){
			$this->table_type = $t_type;
		}
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		public print_tests($user_id, $is_active){
			$db = $this->prepare_connection();
			
			// Decide whether to load active or inactive tables;
			if($is_active == "true")
				$statement = $db->prepare("SELECT test_id, test_number, date_due FROM ". TableNames::TEST ." WHERE teacher_id = ?") or die($db->error);
			else
				$statement = $db->prepare("SELECT test_id, test_number, date_active FROM ". TableNames::TEST ." WHERE teacher_id = ?") or die($db->error);
			
			// Set bind parameters and execute query
			$statement->bind_param("i", $user_id);
			$statement->execute();
			
			if($statement->num_rows > 0){
				while($class = $statement->fetch_assoc()){
					echo "<tr " . "id='" . $class["test_id"] . "'>";
					foreach($record as $col_name => $col_data) {
							if($col_name != "test_id"){
								if($col_name == "test_number")
									echo "<td>Test " . $col_data . "</td>";
								else
									echo "<td>" . $col_data . "</td>";
							}
						}
					echo "</tr>";
				}
			}
			else{
				echo "<tr> <td> No Classes </td> </tr>";
			}
		}
	}
?>