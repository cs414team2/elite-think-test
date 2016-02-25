<?php
	// This ajax block takes a teacher and prints the tests for that teacher.
	require_once("../model/Teacher.php");
	if(isset($_REQUEST['user_id'], $_REQUEST["show_active"])) {
		$teacher = new Teacher();
		$teacher->print_tests($_REQUEST['user_id'], $_REQUEST["show_active"] == "true" ? true : false);
	}
?>