<?php
	if(isset($_REQUEST['question_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'])) {

		$question_id     = $_REQUEST['question_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = htmlspecialchars(ucfirst(trim($_REQUEST['question_text'])));
		$question_weight = $_REQUEST['question_weight'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$editStatement = $eliteConnection->prepare("CALL edit_question(?, ?, ?, ?)") or die($eliteConnection->error);
		$editStatement->bind_param("issi", $question_id, $question_type, $question_text, $question_weight) or die($editStatement->error);
		$editStatement->execute() or die($editStatement->error);
	}
?>