<?php
	include('../model/Admin.php');
	
	// Make sure these constants match up with controllers/class_editor.js
	const STUDENT_NOT_ENROLLED = 0;
	const STUDENT_IS_ENROLLED  = 1;

	if (isset($_REQUEST['class_id'], $_REQUEST['student'])) {
		$class_id = $_REQUEST['class_id'];
		
		// Create the connection string.
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		foreach($_REQUEST['student'] as $student) {
			$student_id  = $student['id'];
			$is_enrolled = $student['enrolled'];
			$update_statement = $elite_connection->prepare("CALL enroll_student(?, ?)")          or die($elite_connection->error);
			$remove_statement = $elite_connection->prepare("CALL drop_student_enrollment(?, ?)") or die($elite_connection->error);
			
			if ($is_enrolled == STUDENT_IS_ENROLLED) {
				$update_statement->bind_param("ii", $student_id, $class_id) or die($update_statement->error);
				$update_statement->execute()                                or die($update_statement->error);
			}
			else {
				$remove_statement->bind_param("ii", $student_id, $class_id) or die($remove_statement->error);
				$remove_statement->execute()                                or die($remove_statement->error);
			}
			
		}
		
		$admin = new Admin();
		$admin->get_students($class_id);
	}
?>