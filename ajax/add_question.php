<?php
	if(isset($_REQUEST['test_id'], $_REQUEST['question_type'])) {

		$test_id         = $_REQUEST['test_id'];
		$question_type   = $_REQUEST['question_type'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$addStatement = $eliteConnection->prepare("CALL add_empty_question(?, ?)") or die($eliteConnection->error);
		$addStatement->bind_param("is", $test_id, $question_type) or die($addStatement->error);
		$addStatement->execute() or die($addStatement->error);
	}
?>