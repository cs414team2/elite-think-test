<?php
	// Contains methods for dealing with student data
	class Student {
		const TEST_ACTIVE      = 1;
		const TEST_EXPIRED     = 2;
		
		// Connect to the csweb database
		public function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		// Print classes for this student in an HTML table format
		public function print_classes($student_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_number, class_name, is_active, class_id
			                           FROM student_classes
									   WHERE student_id = ? AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_number, $class_name, $is_active, $class_id);
			
			if($statement->num_rows > 0){
				while($statement->fetch()){
					echo "<tr " . "id='" . $class_id . "' class='clickable_row'>";
					echo "<td>" . $class_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "</tr>\r\n";
				}
			}
			else{
				echo "<tr> <td colspan='2'> No Classes </td> </tr>";
			}
		}
		
		// Print classes for this student in an HTML dropdown list format
		public function print_classes_dropdown($student_id) {
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT class_id, class_number, class_name 
			                           FROM class
									   WHERE class_id NOT IN (SELECT class_id
									                            FROM enrollment
															   WHERE student_id = ?)
									   AND is_active='Y'") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($class_id, $class_number, $class_name);
		
			if($statement->num_rows > 0){
				echo "<option selected='selected' value='null'>- Select a class -</option>";
				while($statement->fetch()){
					echo "<option " . "value='" . $class_id . "'>";
					echo $class_number . ", " . $class_name;
					echo "</option>";
				}
			}
		}
		
		// Print tests for this student in an HTML table format
		public function print_tests($student_id) {
			$tests_available = 0;
			
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT DISTINCT test_id, test_number, class_number, class_name, date_due, time_limit, question_count
			                           FROM student_tests 
									   WHERE student_id = ? AND date_active < now()") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($test_id, $test_number, $class_number, $class_name, $date_due, $time_limit, $question_count);
			
			while($statement->fetch()){
				$expired_statement = $db->prepare("SELECT get_test_status(student_id, test_id), end_time, pledge_signed
												   FROM   student_test
												   WHERE  student_id = ? AND test_id = ?") or die($db->error);
				$expired_statement->bind_param("ii", $student_id, $test_id);
				$expired_statement->execute();
				$expired_statement->store_result();
				$expired_statement->bind_result($test_status, $end_time, $pledge_signed);
				if($expired_statement->num_rows > 0){
					$expired_statement->fetch();
					if($pledge_signed != 'Y'){
						$tests_available++;
						echo "<tr " . "id='" . $test_id . "' class='clickable_row'>";
						echo "<td>" . $class_number . "</td>";
						echo "<td>" . $class_name . "</td>";
						echo "<td>Test " . $test_number . "</td>";
						echo "<td>" . date('n/j/y', strtotime($date_due)) . "</td>";
						if($time_limit > 0)
							echo "<td>" . $time_limit . " Minute(s)</td>";
						else
							echo "<td> No Limit</td>";
						
						if($test_status == self::TEST_ACTIVE){
							echo "<td style='font-weight:bold;'> Expires: " . date('n/j/y', strtotime($end_time)) . " at ". date('g:i:s a', strtotime($end_time)) ."</td>";
						}
						else if($test_status == self::TEST_EXPIRED)
							echo "<td style='font-weight:bold;'>Expired: Please Sign Pledge</td>";
						echo "<td style='text-align:center;'>" . $question_count . "</td>";
					}
				}
				else{
					$tests_available++;
					echo "<tr " . "id='" . $test_id . "' class='clickable_row'>";
					echo "<td>" . $class_number . "</td>";
					echo "<td>" . $class_name . "</td>";
					echo "<td>Test " . $test_number . "</td>";
					echo "<td>" . date('n/j/y', strtotime($date_due)) . "</td>";
					if($time_limit > 0)
						echo "<td>" . $time_limit . " Minute(s)</td>";
					else
						echo "<td> No Limit</td>";
					echo"<td style='font-weight:bold;'> Not Started </td>";
					echo "<td style='text-align:center;'>" . $question_count . "</td>";
				}
			}
			
			if($tests_available == 0)
				echo "<tr> <td colspan='6' style='text-align:center;'> No Tests Available </td> </tr>";
		}

		// Print all of the graded tests for a student.
		public function print_graded_tests($student_id) {
			$elite_connection = $this->prepare_connection();
			$test_statement = $elite_connection->prepare('SELECT t.test_id, t.test_number, c.class_number, c.class_name, st.grade
														    FROM student_test st
														    JOIN test t ON t.test_id   = st.test_id
														    JOIN class c ON c.class_id = t.class_id
														   WHERE st.student_id = ?
														     AND st.grade IS NOT NULL') or die($elite_connection->error);
			$test_statement->bind_param('i', $student_id) or die($test_statement->error);
			$test_statement->bind_result($test_id, $test_num, $class_num, $class_name, $grade) or die($test_statement->error);
			$test_statement->execute() or die($test_statement->error);
			$test_statement->store_result();
			
			if($test_statement->num_rows > 0){
				while($test_statement->fetch()){
					echo "\r\n<tr class='clickable_row graded_test' data-test-id='".$test_id."'>";
					echo "\r\n<td>Test ".$test_num."</td>";
					echo "\r\n<td>".$class_num."</td>";
					echo "\r\n<td>".$class_name."</td>";
					echo "\r\n<td>".$grade."%</td>";
					echo "\r\n</tr>";
				}
			}
			else {
				echo "\r\n<tr><td colspan='4'>No Graded Tests</td></tr>";
			}
		}
		
		public function print_ungraded_tests($student_id) {
			$elite_connection = $this->prepare_connection();
			$test_statement = $elite_connection->prepare('SELECT t.test_id, t.test_number, c.class_number, c.class_name, st.grade
														    FROM student_test st
														    JOIN test t ON t.test_id   = st.test_id
														    JOIN class c ON c.class_id = t.class_id
														   WHERE st.student_id = ?
														     AND st.grade IS NULL
															 AND st.pledge_signed = "Y"') or die($elite_connection->error);
			$test_statement->bind_param('i', $student_id) or die($test_statement->error);
			$test_statement->bind_result($test_id, $test_num, $class_num, $class_name, $grade) or die($test_statement->error);
			$test_statement->execute() or die($test_statement->error);
			$test_statement->store_result();
			
			if($test_statement->num_rows > 0){
				while($test_statement->fetch()){
					echo "\r\n<tr data-test-id='".$test_id."'>";
					echo "\r\n<td>Test ".$test_num."</td>";
					echo "\r\n<td>".$class_num."</td>";
					echo "\r\n<td>".$class_name."</td>";
					echo "\r\n</tr>";
				}
			}
			else {
				echo "\r\n<tr><td colspan='4'>No Ungraded Tests</td></tr>";
			}
		}
		
		public function get_student_info($student_id){
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT student_fname, student_lname
			                           FROM   student
									   WHERE  student_id = ?") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($student_fname, $student_lname);
			$statement->fetch();
			
			echo $student_lname . ", " . $student_fname . " (" . $student_id . ")";
		}
		
		public function get_full_student_info($student_id){
			$db = $this->prepare_connection();
			$statement = $db->prepare("SELECT student_id, student_fname, student_lname, student_email, student_password
			                           FROM   student
									   WHERE  student_id = ?") or die($db->error);
			$statement->bind_param("i", $student_id);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($student_id, $student_fname, $student_lname, $student_email, $student_password);
			$statement->fetch();
			
			echo "<tr>
					<td id='info_id'>". $student_id ."</td>
					<td id='info_first'>". $student_fname ."</td>
					<td id='info_last'>". $student_lname ."</td>
					<td id='info_email'>". $student_email ."</td>
					<td id='info_password'>". $student_password ."</td>
				</tr>";
		}
	}
?>