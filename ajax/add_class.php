<?php
	// This ajax block takes in a course name, number, and id of a teacher and
	// passes them to the cs414 database.

	require_once('../model/CS414Connection.php');
	require_once("../model/ErrorLogger.php");
	
	if(isset($_REQUEST['course_name'], $_REQUEST['course_number'], $_REQUEST['teacher_id'])) {
		$course_name   = strip_tags(ucwords(trim($_REQUEST['course_name'])));
		$course_number = strip_tags(strtoupper(trim($_REQUEST['course_number'])));
		$teacher_id    = trim($_REQUEST['teacher_id']);
		
		if ($teacher_id == "null") {
			$teacher_id = null;
		}
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");		
		
		$addStatement = $eliteConnection->prepare("CALL create_class(?, ?, ?)") or die($eliteConnection->error);
		$addStatement->bind_param("ssi", $course_number, $course_name, $teacher_id)or die($addStatement->error);
		$addStatement->execute()or die($addStatement->error);
	}
	else {
		new ErrorLogger('ajax/add_class.php - line 8 isset returned false');
	}
?>