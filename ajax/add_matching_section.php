<?php
	// This AJAX block takes in a matching section and adds it to a database.

	require_once("../model/Test.php");

	if(isset($_REQUEST['test_id'], $_REQUEST['section_description'], $_REQUEST['question_weight'], $_REQUEST['questions'], $_REQUEST['answers'])) {

		$test_id             = $_REQUEST['test_id'];
		$section_description = $_REQUEST['section_description'];
		$question_weight     = $_REQUEST['question_weight'];
		
		$test = new Test($test_id);
		
		// Create the connection string and start the transaction.
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		$elite_connection->autocommit(FALSE);
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$elite_connection->query('SET @section_id = 0');
		$elite_connection->query('SET @answer_id = 0');
		$elite_connection->query('set @answer_id = 0');
		
		try {
			// Store the matching section in the database
			$section_statement = $elite_connection->prepare('CALL add_matching_section(?, ?, @section_id)');
			$section_statement->bind_param('si', $section_description, $test_id);
			$section_statement->execute();
			$add_result = $elite_connection->query('select @section_id as section_id');
			$section_info = $add_result->fetch_assoc();

			// Store the answers in the database
			foreach($_REQUEST['answers'] as $answer_number => $answer) {
				$answer_text = $answer['text'];
				
				$answer_statement = $elite_connection->prepare('CALL add_matching_answer(?,?, @answer_id)');
				$answer_statement->bind_param('si', $answer_text, $section_info['section_id']);
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
			foreach($_REQUEST['questions'] as $question_number => $question) {
				$question_text  = $question['text'];
				$matched_answer = $question['answer'];
				$question_statement = $elite_connection->prepare('CALL add_matching_question(?,?,?,?, @question_id)');
				$question_statement->bind_param('siii', $question_text, $question_weight, $section_info['section_id'], $matched_answer);
				$question_statement->execute();
				$add_result = $elite_connection->query('select @question_id as question_id');
				$question_info = $add_result->fetch_assoc();
				
				$_REQUEST['questions'][$question_number]['id'] = $question_info['question_id'];
			}
			
			$elite_connection->commit();
		}
		catch(Exception $e){
			$elite_connection->rollback();
		}
		$elite_connection->autocommit(TRUE);
		
		/*// Print the questions and answers.                                      !!!!!!THIS IS COPYPASTA FROM ADD_QUESTION!!!!!!!!!!!!!
		$test->print_question($questionInfo['question_id'], $question_text, $_SESSION['credentials']->get_access_level(), $question_type, $question_weight);
		
		if($question_type == Test::MULTIPLE_CHOICE_QUESTION_TYPE)
			echo "<ol style='list-style-type:lower-alpha; margin-left: 20px; margin-bottom: 1px; font-family: Segoe UI Light;'>";
				
		foreach($_REQUEST['answers'] as $answer) {
			$answer_info = $addResult->fetch_assoc();
			$test->print_answer($answer['is_correct'], trim($answer['answer_text']), 
								$question_type, TEACHER, $question_id, $answer_info['answer_id'], null);
		}

		if($question_type == Test::MULTIPLE_CHOICE_QUESTION_TYPE)
			echo "</ol>";
		echo "\r\n</li>";*/

	}
	else {
		throw new Exception("Not all section information provided.");
	}
?>