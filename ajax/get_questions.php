<?php
	require_once('../model/Test.php');
	require_once('../model/Session.php');
	session_start();
	
	const TRUE_FALSE_INDEX   = 0;
	const MC_INDEX           = 1;
	const ESSAY_INDEX        = 2;
	const MAX_QUESTION_TYPES = 3;
	
	// Create the connection string.
	function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}

	if(isset($_SESSION["credentials"], $_REQUEST["test_id"])){
		$test_id    = $_REQUEST["test_id"];
		$test       = new Test($test_id);
		
		// Get the questions.
		$db = prepare_connection();
		$question_statement = $db->prepare("SELECT question_id, question_text, question_type FROM question WHERE test_id = ? and question_type = '".Test::TRUE_FALSE_QUESTION_TYPE."'") or die($db->error);
		$question_statement->bind_param("i", $test_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_type);
		
		// Print the questions and answers.
		if($question_statement->num_rows > 0){
			echo "<div class='my-form-builder' id='".Test::TRUE_FALSE_QUESTION_TYPE."'>";
			echo "<h4> T/F Questions </h4>";
			while($question_statement->fetch()){
				$test->print_question($question_id, $question_text, $_SESSION["credentials"]->get_access_level());
				
				$answer_statement = $db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?");
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				
				if($answer_statement->num_rows > 0)
					while($answer_statement->fetch())
						$test->print_answer($is_correct, $answer_content, $question_type, $_SESSION["credentials"]->get_access_level(), $question_id, $answer_id);
				echo "\r\n</div>";
			}
		}
		else
			echo "<div class='my-form-builder' id='".Test::TRUE_FALSE_QUESTION_TYPE."' style='display:none;'>";
		echo "</div>";
		
		// Get the questions.
		$db = prepare_connection();
		$question_statement = $db->prepare("SELECT question_id, question_text, question_type FROM question WHERE test_id = ? and question_type = '".Test::MULTIPLE_CHOICE_QUESTION_TYPE."'") or die($db->error);
		$question_statement->bind_param("i", $test_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_type);
		
		if($question_statement->num_rows > 0){
			echo "<div class='my-form-builder' id='".Test::MULTIPLE_CHOICE_QUESTION_TYPE."'>";
			echo "<h4> Multiple Choice Questions </h4>";
			while($question_statement->fetch()){
				$test->print_question($question_id, $question_text, $_SESSION["credentials"]->get_access_level());
				
				$answer_statement = $db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?");
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				
				echo "<ol style='list-style-type:lower-alpha; margin-left: 20px; margin-bottom: 1px; font-family Segoe UI Light;'>";
				if($answer_statement->num_rows > 0)
					while($answer_statement->fetch())
						$test->print_answer($is_correct, $answer_content, $question_type, $_SESSION["credentials"]->get_access_level(), $question_id, $answer_id);
				echo "</ol>";
				echo "\r\n</div>";
			}
		}
		else
			echo "<div class='my-form-builder' id='".Test::MULTIPLE_CHOICE_QUESTION_TYPE."' style='display:none;'>";
		echo "</div>";
		
		// Get the questions.
		$db = prepare_connection();
		$question_statement = $db->prepare("SELECT question_id, question_text, question_type FROM question WHERE test_id = ? and question_type = '".Test::ESSAY_QUESTION_TYPE."'") or die($db->error);
		$question_statement->bind_param("i", $test_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_type);
		
		// Print the questions and answers.
		if($question_statement->num_rows > 0){
			echo "<div class='my-form-builder' id='".Test::ESSAY_QUESTION_TYPE."'>";
			echo "<h4> Essay Questions </h4>";
			while($question_statement->fetch()){
				$test->print_question($question_id, $question_text, $_SESSION["credentials"]->get_access_level());
				$test->print_essay_answer($question_id, $_SESSION["credentials"]->get_access_level());
				echo "\r\n</div>";
			}
		}
		else
			echo "<div class='my-form-builder' id='".Test::ESSAY_QUESTION_TYPE."'style='display:none;'>";
		echo "</div>";
	}
	
?>