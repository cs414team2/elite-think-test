<?php
	if(isset($_REQUEST['question_text'], $_REQUEST['question_type'], $_REQUEST['test_id'], $_REQUEST['question_weight'], 
	         $_REQUEST['question_id'], $_REQUEST['answer_content'], $_REQUEST['is_correct'])) {
		$question_text   = $_REQUEST['question_text'];
		$question_type   = $_REQUEST['question_type'];
		$test_id         = $_REQUEST['test_id'];
		$question_weight = $_REQUEST['question_weight'];
		$question_id     = $_REQUEST['question_id'];
		$answer_content  = $_REQUEST['answer_content'];
		$is_correct      = $_REQUEST['is_correct'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$addStatement = $eliteConnection->prepare("CALL add_question(?, ?, ?, ?)") or die($eliteConnection->error);
		$addStatement->bind_param("ssii", $question_text, $question_type, $test_id, $question_weight);
		$addStatement->execute();
	}
?>