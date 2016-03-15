<?php
	// This ajax block takes in a test and a student and 
	// checks to see if the student has started or completed the test.
	require_once('../model/Test.php');
	
	// These constants must match controllers/test_taker.js
	const TEST_NOT_STARTED = 0;
	const TEST_STARTED     = 1;
	const TEST_SUBMITTED   = 2;
	const TEST_TIMED_OUT   = 3;
	
	/*if (isset($_REQUEST['test_id'], $_REQUEST['student_id'])) {
		$test_id    = $_REQUEST['test_id'];
		$student_id = $_REQUEST['student_id'];
		$test = new Test($test_id);
		
		if ($test->has_started($student_id)) {
			if ($test->is_completed($student_id)) {
				echo TEST_SUBMITTED;
			}
			else {
				if ($test->has_timed_out($student_id)) {
					echo TEST_TIMED_OUT;
				}
				else {
					echo TEST_STARTED;
				}
			}
		}
		else {
			echo TEST_NOT_STARTED;
		}*/ echo TEST_STARTED;
?>