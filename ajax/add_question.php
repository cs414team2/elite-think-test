<?php
	require_once("../model/Test.php");
	
	// Make sure these constants match up with controllers/test_editor.js !
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE = 'TF';
	const ESSAY_QUESTION_TYPE = 'ESSAY';
	
	$test = new Test();

	if(isset($_REQUEST['test_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'], $_REQUEST['answers'])) {

		$test_id         = $_REQUEST['test_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = ucfirst(trim($_REQUEST['question_text']));
		$question_weight = $_REQUEST['question_weight'];
		
		// Create the connection string.
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		// Store the question in the database.
		$eliteConnection->query("SET @question_id = 0")                                      or die($eliteConnection->error);	
		$addStatement = $eliteConnection->prepare("CALL add_question(?, ?, ?, ?, @question_id)") or die($eliteConnection->error);
		$addStatement->bind_param("ssii", $question_text, $question_type, $test_id, $question_weight) 			   or die($addStatement->error);
		$addStatement->execute()                                                                                   or die($addStatement->error);
		$addResult = $eliteConnection->query("SELECT @question_id as question_id");
		$questionInfo = $addResult->fetch_assoc();
		
		// Store the answers in the database.
		if ($question_type == MULTIPLE_CHOICE_QUESTION_TYPE || $question_type == TRUE_FALSE_QUESTION_TYPE) {
			$addStatement = $eliteConnection->prepare("CALL add_answer(?,?,?)") or die($eliteConnection->error);
			
			foreach($_REQUEST['answers'] as $answer) {
				$question_id = $questionInfo['question_id'];
				$answer_text = $answer['answer_text'];
				$answer_is_correct = $answer['is_correct'];
				
				$addStatement->bind_param("iss", $question_id, $answer_text, $answer_is_correct) or die($addStatement->error);
				$addStatement->execute()                                                         or die($addStatement->error);
			}
		}
		
		// Print the questions and answers.
		$test->print_question($questionInfo['question_id'], $question_text);
		if ($question_type == MULTIPLE_CHOICE_QUESTION_TYPE || $question_type == TRUE_FALSE_QUESTION_TYPE) {
			$count = 0;
			foreach($_REQUEST['answers'] as $answer) {
				$test->print_answer($answer['is_correct'], $count, $answer['answer_text'], $question_type);
				$count++;
			}										
		}
			
		echo "\r\n</div>";

	}
	else {
		throw new Exception("Not all question information provided.");
	}
?>