<?php
	// This ajax block takes a class and prints the students in that class.
	require_once("../model/Course.php");
	if(isset($_REQUEST['class_id'])) {
		$course = new Course($_REQUEST['class_id']);
		$course->print_students();
	}
?>