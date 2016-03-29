<?php
	// This ajax block takes in essay question grades and passes them to a database.
	if (isset($_REQUEST['student_test_id'], $_REQUEST['grades'])) {
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		$add_statement    = $elite_connection->prepare("CALL add_essay_grade(?,?)")                  or die($add_statement->error);
		
		foreach ($_REQUEST['grades'] as $grade) {
			//bind_param("ii", answer_id, points_recieved
		}
	}
?>