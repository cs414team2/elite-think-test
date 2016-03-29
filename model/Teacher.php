<?php
	// Contains methods to print out different information that a teacher might need
	class Teacher {
		// Connects to the csweb database
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}

		// Prints out classes for this teacher in an HTML table format
		public function print_classes($teacher_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name 
			                           FROM class 
									   WHERE teacher_id = ? AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $teacher_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_id, $class_number, $class_name);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<tr " . "id='" . $class_id . "' class='clickable_row editable_class'>";
					echo "<td>" . $class_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "</tr>\r\n";
				}
			}
			else{
				echo "<tr> <td> No Classes </td> </tr>";
			}
		}
		
		// Prints out classes for this teacher in an HTML dropdown list format
		public function print_classes_dropdown($teacher_id) {
			$db = $this->prepare_connection();
			
			$statement = $db->prepare("SELECT class_id, class_number, class_name 
			                           FROM class 
									   WHERE teacher_id = ? AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $teacher_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_id, $class_number, $class_name);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<option " . "value='" . $class_id . "'>";
					echo $class_number . ", " . $class_name;
					echo "</option>";
				}
			}
			else{
				echo "<option>" . $teacher_id. " </option>";
			}
		}
		
		// Prints out tests for a teacher in an HTML table format
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
					echo "<tr " . "id='" . $test_id . "' class='clickable_row ";
					if (!$is_active)
						echo "editable_test";
					else
						echo "gradeable_test";
					echo "'><td>Test " . $test_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "<td>" . date('n/j/y', strtotime($date_due)) . "</td>";
					echo "</tr>\r\n";
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
		// Displays the Teacher's name
		public function get_teacher_info($teacher_id){
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT teacher_fname, teacher_lname
									   FROM   teacher
									   WHERE  teacher_id = ?") or die($db->error);
			$statement->bind_param("i", $teacher_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($teacher_fname, $teacher_lname);
			$statement->fetch();
			
			echo $teacher_lname . ", " . $teacher_fname . " (" . $teacher_id . ")";
		}
		
		public function get_full_teacher_info($teacher_id){
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT teacher_id, teacher_fname, teacher_lname, teacher_email, teacher_password
			                           FROM   teacher
									   WHERE  teacher_id = ?") or die($db->error);
			$statement->bind_param("i", $teacher_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($teacher_id, $teacher_fname, $teacher_lname, $teacher_email, $teacher_password);
			$statement->fetch();
			
			echo "<tr>
					<td>". $teacher_id ." </td>
					<td>". $teacher_fname ."</td>
					<td>". $teacher_lname ."</td>
					<td>". $teacher_email ."</td>
					<td>". $teacher_password ."</td>
				</tr>";
		}
	}
?>