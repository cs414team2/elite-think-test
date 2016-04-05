<?php
	// This ajax block takes an updated matching section and updates the section in the database.

	require_once('../model/Test.php');
	
	if(isset($_REQUEST['test_id'], $_REQUEST['section_id'], $_REQUEST['section_description'], $_REQUEST['question_weight'], $_REQUEST['questions'], $_REQUEST['answers'])) {
		$test_id             = $_REQUEST['test_id'];
		$section_id          = $_REQUEST['section_id'];
		$section_description = ucfirst(trim($_REQUEST['section_description']));
		$question_weight     = $_REQUEST['question_weight'];
		$test                = new Test($test_id);
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		
		$section_statement  = $elite_connection->prepare('CALL edit_section(?,?)');
		$section_statement->bind_param('is', $section_id, $section_description);
		$section_statement->execute();
		
		
		// Store the answers in the database
		$elite_connection->query('SET @answer_id = 0');
		foreach($_REQUEST['answers'] as $answer_number => $answer) {
			$answer_text = trim($answer['text']);
			
			$answer_statement = $elite_connection->prepare('CALL add_matching_answer(?,?, @answer_id)');
			$answer_statement->bind_param('si', $answer_text, $section_id);
			$answer_statement->execute();
			$add_result = $elite_connection->query('select @answer_id as answer_id');
			$answer_info = $add_result->fetch_assoc();
			
			$_REQUEST['answers'][$answer_number]['id'] = $answer_info['answer_id'];
		}

		// Set the questions so they link to their answer's id in the database.
		foreach($_REQUEST['questions'] as $question_number => $question) {
			foreach ($_REQUEST['answers'] as $answer) {
				if ($question['answer'] == $answer['index']){
					$_REQUEST['questions'][$question_number]['answer'] = $answer['id'];
				}
			}
		}

		// Store the questions in the database
		$elite_connection->query('SET @question_id = 0');
		foreach($_REQUEST['questions'] as $question_number => $question) {
			$question_text  = trim($question['text']);
			$matched_answer = $question['answer'];
			$question_statement = $elite_connection->prepare('CALL add_matching_question(?,?,?,?, @question_id)');
			$question_statement->bind_param('siii', $question_text, $question_weight, $section_id, $matched_answer);
			$question_statement->execute();
			$add_result = $elite_connection->query('select @question_id as question_id');
			$question_info = $add_result->fetch_assoc();
			
			$_REQUEST['questions'][$question_number]['id'] = $question_info['question_id'];
		}
		
		$test->print_section($section_id, $section_description);
		
	}
?>