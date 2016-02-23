<?php
	require_once('TableNames.php');
	class Tests {
		private $table_type;
		
		public function __constructor($t_type){
			$this->table_type = $t_type;
		}
		
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		public function print_tests($user_id, $is_active){
			$db = $this->prepare_connection();
			
			// Decide whether to load active or inactive tables;
			if($is_active)
				$statement = $db->prepare("SELECT test_id, test_number, date_due, class_name 
			                               FROM teacher_active_tests
			                               WHERE teacher_id = ?") or die($db->error);
			else
				$statement = $db->prepare("SELECT test_id, test_number, date_active, class_name
			                               FROM teacher_inactive_tests
			                               WHERE teacher_id = ?") or die($db->error);
			
			// Set bind parameters and execute query
			$statement->bind_param("i", $user_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($test_id, $test_number, $date_due, $class_name);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<tr " . "id='" . $test_id . "'>";
					echo "<td>Test " . $test_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "<td>" . $date_due . "</td>";
					echo "</tr>";
				}
			}
			else{
				echo "<tr>";
				echo "<td> N/A </td>";
				echo "<td> N/A </td>";
				echo "<td> N/A </td>";
				echo "</tr>";
			}
		}
	}
?>