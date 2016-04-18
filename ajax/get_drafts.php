<?php
	// This ajax block takes a teacher and prints the tests for that teacher.
	require_once("../model/Teacher.php");
	if(isset($_REQUEST['user_id'])) {
		$teacher = new Teacher();
		$teacher->print_drafts($_REQUEST['user_id']);
	}
?>