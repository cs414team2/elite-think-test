<?php
	require_once('../model/StudentTest.php');
	require_once('../model/Session.php');
	if(isset($_REQUEST['student_id'], $_REQUEST['test_id'])) {
		$test = new StudentTest($_REQUEST['test_id'], $_REQUEST['student_id']);
		
		$test->print_test(Session::TEACHER);
	}
?>