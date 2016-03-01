<?php
	if(isset($_REQUEST['test_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'])) {

		$test_id         = $_REQUEST['test_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = $_REQUEST['question_text'];
		$question_weight = $_REQUEST['question_weight'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");

		$eliteConnection->query("SET @question_id = 0, @question_number = 0")                                      or die($eliteConnection->error);
				
		$addStatement = $eliteConnection->prepare("CALL add_question(?, ?, ?, ?, @question_id, @question_number)") or die($eliteConnection->error);
		$addStatement->bind_param("ssii", $question_text, $question_type, $test_id, $question_weight) 			   or die($addStatement->error);
		$addStatement->execute()                                                                                   or die($addStatement->error);

		$addResult = $eliteConnection->query("SELECT @question_id as question_id, @question_number as question_number");
		$questionInfo = $addResult->fetch_assoc();
		
		echo "<div id='".$questionInfo['question_id']."'>".$questionInfo['question_number'];
		echo "<button onclick='delete_question(this.parentElement)' ></button></div>"
	}
?>