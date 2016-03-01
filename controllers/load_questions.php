<?php
	include('model/Test.php');
	
	const CORRECT   = 'Y';
	const INCORRECT = 'N';
	
	function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}

	if(isset($_REQUEST["test_id"])){
		$test_id = $_REQUEST["test_id"];
		$test = new Test();
		
		$db = prepare_connection();
		$question_statement = $db->prepare("SELECT question_id, question_text, question_type FROM question WHERE test_id = ?");
		$question_statement->bind_param("i", $test_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_type);
		
		if($question_statement->num_rows > 0){
			while($question_statement->fetch()){
				// Counts number of answers printed for the question
				$count = 0;
				
				$test->print_question($question_id, $question_text);
				
				$answer_statement = $db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?");
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				if($answer_statement->num_rows > 0){
					while($answer_statement->fetch()){
						// Make these work properly after pulling in answers as well.
						//if ($question_type == TRUE_FALSE_QUESTION_TYPE) {
							$test->print_answer($is_correct, $count, $answer_content);
						//}
						/*elseif ($question_type == MULTIPLE_CHOICE_QUESTION_TYPE) {
							echo "\r\n
									  <div style='display: inline-block; max-width: 50%; float:left;'> This is a possible answer </div> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									  <div style='display: inline-block; max-width: 50%;'>    This is a possible answer   </div>	<br/>
									  <div style='display: inline-block; max-width: 50%; float:left;'>    This is a possible answer   </div>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									  <div style='display: inline-block; max-width: 50%;'>    This is a possible answer </div>";														
						}*/
						$count++;
					}
				}
				echo "\r\n</div> </br>";
			}
		}
	}
?>