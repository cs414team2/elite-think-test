<?php
	// This ajax block takes in essay question grades and passes them to a database.
	
	require_once("../model/ErrorLogger.php");
	
	function log_and_die($error) {
		new ErrorLogger('ajax/submit_essay_grades.php '.$error);
		die();
	}
	
	if (isset($_REQUEST['test_id'], $_REQUEST['student_id'])) {
		$test_id          = $_REQUEST['test_id'];
		$student_id       = $_REQUEST['student_id'];
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		$add_statement    = $elite_connection->prepare("CALL add_essay_grade(?,?)") or log_and_die($elite_connection->error);
		
		if (isset($_REQUEST['grade'])) {
			foreach ($_REQUEST['grade'] as $grade) {
				$student_answer_id = $grade['student_answer_id'];
				$points_recieved   = $grade['points_recieved'];
				
				$add_statement->bind_param("id", $student_answer_id, $points_recieved) or log_and_die(' :line 22 ' . $add_statement->error);
				$add_statement->execute() or log_and_die(' :line 23 ' . $add_statement->error);
			}
		}
		$add_statement->close();
		
		$finalized_statement = $elite_connection->prepare("CALL set_final_grade(?,?)") or log_and_die( ':line 28 ' . $elite_connection->error);
		$finalized_statement->bind_param("ii", $student_id, $test_id) or log_and_die(':line 29 ' . $finalized_statement->error);
		$finalized_statement->execute() or log_and_die(':line 30 ' . $finalized_statement->error);
		
	}
	else {
		new ErrorLogger('ajax/submit_essay_grades.php: line 11: isset returned false');
	}
?>