<?php
	//This ajax block takes a student and prints the graded tests for that student.
	require_once("../model/Student.php");
	if(isset($_REQUEST['student_id'])) {
		$student = new Student();
		$student->print_graded_tests($_REQUEST['student_id']);
	}
?>