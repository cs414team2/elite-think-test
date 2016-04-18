<?php
	// This ajax block takes a teacher and prints the tests for that teacher.
	require_once("../model/Teacher.php");
	if(isset($_REQUEST['user_id'], $_REQUEST["show_graded"])) {
		$teacher = new Teacher();
		$teacher->print_tests($_REQUEST['user_id'], $_REQUEST["show_graded"] == "true" ? true : false);
	}
?>