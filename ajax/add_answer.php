<?php
	if(isset($_REQUEST['question_id'], $_REQUEST['answer_content'], $_REQUEST['is_correct'])) {
		$question_id = $_REQUEST['question_id'];
		$answer_content = $_REQUEST['answer_content'];
		$is_correct = $_REQUEST['is_correct'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$addStatement = $eliteConnection->prepare("CALL add_question(?, ?, ?)") or die($eliteConnection->error);
		$addStatement->bind_param("ssisi", $question_id, $answer_content, $is_correct);
		$addStatement->execute();
	}
?>