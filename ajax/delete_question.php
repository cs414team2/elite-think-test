<?php
	if(isset($_REQUEST['question_id'])) {
		$question_id = $_REQUEST['question_id'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$deleteStatement = $eliteConnection->prepare("CALL delete_question(?)") or die($deleteStatement->error);
		$deleteStatement->bind_param("i", $question_id) or die($deleteStatement->error);
		$deleteStatement->execute() or die($deleteStatement->error);
	}
?>