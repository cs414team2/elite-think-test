<?php
	//This ajax block takes a student and prints the classes for that student.
	require_once("../model/Student.php");
	if(isset($_REQUEST['user_id'])) {
		$student = new Student();
		$student->print_classes($_REQUEST['user_id']);
	}
?>