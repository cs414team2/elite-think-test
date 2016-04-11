<?php
	//This ajax block takes a student and prints the ungraded tests for that student.
	require_once("../model/Student.php");
	if(isset($_REQUEST['student_id'])) {
		$student = new Student();
		$student->print_ungraded_tests($_REQUEST['student_id']);
	}
?>