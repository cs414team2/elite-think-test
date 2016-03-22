<?php
	if(isset($_REQUEST['question_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'], $_REQUEST['answers'])) {

		$question_id     = $_REQUEST['question_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = ucfirst(trim($_REQUEST['question_text']));
		$question_weight = $_REQUEST['question_weight'];
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$edit_statement = $elite_connection->prepare("CALL edit_question(?, ?, ?)")        or die($elite_connection->error);
		$edit_statement->bind_param("isi", $question_id, $question_text, $question_weight) or die($edit_statement->error);
		$edit_statement->execute() or die($edit_statement->error)                        or die($edit_statement->error);
		
		$edit_statement = $elite_connection->prepare("CALL edit_answer(?, ?, ?)")        or die($elite_connection->error);
		foreach($_REQUEST['answers'] as $answer){
			$answer_id   = $answer['answer_id'];
			$answer_text = trim($answer['answer_text']);
			$is_correct  = $answer['is_correct'];
			
			$edit_statement->bind_param("iss", $answer_id, $answer_text, $is_correct) or die($edit_statement->error);
			$edit_statement->execute()                                                or die($edit_statement->error);
		}
	}
?>