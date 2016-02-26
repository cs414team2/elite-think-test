<?php
	// This ajax block takes a teacher and prints the classes for that teacher.
	require_once("../model/Teacher.php");
	if(isset($_REQUEST['user_id'])) {
		$teacher = new Teacher();
		$teacher->print_classes($_REQUEST['user_id']);
	}
?>