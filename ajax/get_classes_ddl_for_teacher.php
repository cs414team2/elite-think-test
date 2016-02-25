<?php
	// This ajax block takes a teacher and prints a drop down list of classes for the teacher.
	require_once("../model/Teacher.php");
	if(isset($_REQUEST['user_id'])) {
		$teacher = new Teacher();
		$teacher->get_classes_dropdown($_REQUEST['user_id']);
	}
?>