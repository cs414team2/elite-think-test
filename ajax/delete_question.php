<?php
	// This ajax block takes a question id and removes the question from the database.

	if(isset($_REQUEST['question_id'], $_REQUEST['test_id'])) {
		$question_id = $_REQUEST['question_id'];
		$test_id     = $_REQUEST['test_id'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$deleteStatement = $eliteConnection->prepare("CALL delete_question(?, ?)") or die($deleteStatement->error);
		$deleteStatement->bind_param("ii", $question_id, $test_id)               or die($deleteStatement->error);
		$deleteStatement->execute()                                           or die($deleteStatement->error);
	}
?>