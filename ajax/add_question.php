<?php
	require_once("../model/Test.php");
	require_once("../model/Session.php");
	session_start();
	
	// Make sure these constants match up with model/Session.php !
	const UNAUTHENTICATED = 0;
	const ADMINISTRATOR = 1;
	const TEACHER = 2;
	const STUDENT = 3;
	
	$test = new Test();

	if(isset($_REQUEST['test_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'], $_REQUEST['answers'])) {

		$test_id         = $_REQUEST['test_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = htmlspecialchars(ucfirst(trim($_REQUEST['question_text'])), ENT_QUOTES);
		$question_weight = $_REQUEST['question_weight'];
		
		// Create the connection string.
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		// Store the question in the database.
		$eliteConnection->query("SET @question_id = 0")                                               or die($eliteConnection->error);	
		$addStatement = $eliteConnection->prepare("CALL add_question(?, ?, ?, ?, @question_id)")      or die($eliteConnection->error);
		$addStatement->bind_param("ssii", $question_text, $question_type, $test_id, $question_weight) or die($addStatement->error);
		$addStatement->execute()                                                                      or die($addStatement->error);
		$addResult = $eliteConnection->query("SELECT @question_id as question_id");
		$questionInfo = $addResult->fetch_assoc();
		
		// Store the answers in the database.
		if ($question_type == Test::MULTIPLE_CHOICE_QUESTION_TYPE || $question_type == Test::TRUE_FALSE_QUESTION_TYPE) {
			$addStatement = $eliteConnection->prepare("CALL add_answer(?,?,?)") or die($eliteConnection->error);
			
			foreach($_REQUEST['answers'] as $answer) {
				$question_id = $questionInfo['question_id'];
				$answer_text = htmlspecialchars(trim($answer['answer_text']));
				$answer_is_correct = $answer['is_correct'];
				
				$addStatement->bind_param("iss", $question_id, $answer_text, $answer_is_correct) or die($addStatement->error);
				$addStatement->execute()                                                         or die($addStatement->error);
			}
		}
		
		// Print the questions and answers.
		$test->print_question($questionInfo['question_id'], $question_text, $_SESSION['credentials']->get_access_level());
		
		if($question_type == Test::MULTIPLE_CHOICE_QUESTION_TYPE)
			echo "<ol style='list-style-type:lower-alpha; margin-left: 20px; margin-bottom: 1px; font-family: Segoe UI Light;'>";
				
		foreach($_REQUEST['answers'] as $answer) {
			if($question_type == Test::ESSAY_QUESTION_TYPE)
					$test->print_essay_answer(Test::TEACHER);
			else
				$test->print_answer($answer['is_correct'],  htmlspecialchars(trim($answer['answer_text'])), 
									$question_type, TEACHER, $question_id, null);
		}

		if($question_type == Test::MULTIPLE_CHOICE_QUESTION_TYPE)
			echo "</ol>";
		echo "\r\n</div>";

	}
	else {
		throw new Exception("Not all question information provided.");
	}
?>