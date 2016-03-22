<?php
	// This ajax block takes student answers to questions and stores them in the database.
	
	if (isset($_REQUEST['test'], $_REQUEST['student_id'])) {
		$student_id = $_REQUEST['student_id'];
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		$add_statement = $elite_connection->prepare("CALL add_student_answer(?,?,?)")                  or die($add_statement->error);
		
		foreach ($_REQUEST['test'] as $question) {
			$question_id = $question['question_id'];
			$answer_given = trim($question['answer_given']);
			
			$add_statement->bind_param("iis", $student_id, $question_id, $answer_given) or die($add_statement->error);
			$add_statement->execute() or die($add_statement->error);
		}
	}
?>