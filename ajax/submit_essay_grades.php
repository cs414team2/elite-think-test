<?php
	// This ajax block takes in essay question grades and passes them to a database.
	if (isset($_REQUEST['test_id'], $_REQUEST['student_id'])) {
		$test_id          = $_REQUEST['test_id'];
		$student_id       = $_REQUEST['student_id'];
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		$add_statement    = $elite_connection->prepare("CALL add_essay_grade(?,?)")                  or die($add_statement->error);
		
		if (isset($_REQUEST['grade'])) {
			foreach ($_REQUEST['grade'] as $grade) {
				$student_answer_id = $grade['student_answer_id'];
				$points_recieved   = $grade['points_recieved'];
				
				$add_statement->bind_param("id", $student_answer_id, $points_recieved) or die($add_statement->error);
				$add_statement->execute() or die($add_statement->error);
			}
		}
		$add_statement->close();
		
		$finalized_statement = $elite_connection->prepare("CALL set_final_grade(?,?)") or die($elite_connection->error);
		$finalized_statement->bind_param("ii", $student_id, $test_id) or die($finalized_statement->error);
		$finalized_statement->execute() or die($finalized_statement->error);
		
		echo $test_id . " " . $student_id;
		
	}
?>