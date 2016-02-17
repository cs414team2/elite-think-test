<?php
	require_once('../model/CS414Connection.php');
	
	if(isset($_REQUEST['courseName'], $_REQUEST['courseNumber'], $_REQUEST['Teacher'])) {
		$course_name = trim($_REQUEST['courseName']);
		$course_number = trim($_REQUEST['courseNumber']);
		$teacher_id = trim($_REQUEST['Teacher']);
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");		
		
		// We need to make it send a null if the teacher id is "0" (or don't send a value and see if that makes it null);
		$addStatement = $eliteConnection->prepare("CALL create_class(?, ?, ?)") or die($db->error);
		$addStatement->bind_param("ssi", $course_name, $course_number, $teacher_id);
		$addStatement->execute();
	}
?>