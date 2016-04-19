<?php
	require_once('../model/Test.php');

	if(isset($_REQUEST['question_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'], $_REQUEST['answers'])) {

		$question_id     = $_REQUEST['question_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = ucfirst(trim($_REQUEST['question_text']));
		$question_weight = $_REQUEST['question_weight'];
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$edit_statement = $elite_connection->prepare("CALL edit_question(?, ?, ?)")        or die($elite_connection->error);
		$edit_statement->bind_param("isi", $question_id, $question_text, $question_weight) or die($edit_statement->error);
		$edit_statement->execute() or die($edit_statement->error)                        or die($edit_statement->error);
		
		if ($question_type == Test::MULTIPLE_CHOICE_QUESTION_TYPE) {
			$edit_statement = $elite_connection->prepare("CALL delete_multiple_choice_answers(?)");
			$edit_statement->bind_param("i", $question_id);
			$edit_statement->execute();
			
			$elite_connection->query("SET @answer_id = 0");
			$edit_statement = $elite_connection->prepare("CALL add_answer(?, ?, ?, @answer_id)");
			
			foreach($_REQUEST['answers'] as $answer) {
				$answer_text = trim($answer['answer_text']);
				$is_correct  = $answer['is_correct'];
				$edit_statement->bind_param('iss', $question_id, $answer_text, $is_correct);
				$edit_statement->execute();
				$add_result = $elite_connection->query('SELECT @answer_id as answer_id');
				
				$answer_info = $add_result->fetch_assoc();
				
				if($is_correct == 'Y')
					echo "\r\n<li style='color:#47CC7A; font-family: Segoe UI Light;'> <span class='answer' data-answer-id='".$answer_info['answer_id']."' data-is-correct='Y'>".htmlspecialchars($answer_text)."</span><span class='symbol'>&nbsp;&#10004;</span></li>";
				else
					echo "\r\n<li style='color:#CC1C11; font-family: Segoe UI Light;'> <span class='answer' data-answer-id='".$answer_info['answer_id']."' data-is-correct='N'>".htmlspecialchars($answer_text)."</span><span class='symbol'>&nbsp;&#10006;</span></li>";
				
			}
		}
		else {
			$edit_statement = $elite_connection->prepare("CALL edit_answer(?, ?, ?)")        or die($elite_connection->error);
			foreach($_REQUEST['answers'] as $answer){
				$answer_id   = $answer['answer_id'];
				$answer_text = trim($answer['answer_text']);
				$is_correct  = $answer['is_correct'];
				
				$edit_statement->bind_param("iss", $answer_id, $answer_text, $is_correct) or die($edit_statement->error);
				$edit_statement->execute()                                                or die($edit_statement->error);
			}			
		}
	}
?>