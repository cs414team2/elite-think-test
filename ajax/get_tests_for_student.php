<?php
	//This ajax block takes a student and prints the tests for that student.
	require_once("../model/Student.php");
	if(isset($_REQUEST['user_id'])) {
		$student = new Student();
		$student->print_tests($_REQUEST['user_id']);
	}
?>