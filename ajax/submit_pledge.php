<?php
	if(isset($_REQUEST['test_id'], $_REQUEST['student_id'])) {
		$test_id    = $_REQUEST['test_id'];
		$student_id = $_REQUEST['student_id'];
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		$pledge_statement = $elite_connection->prepare("CALL submit_pledge(?,?)")                    or die($pledge_statement->error);
		$pledge_statement->bind_param("ii", $student_id, $test_id)                                  or die($pledge_statement->error);
		$pledge_statement->execute()                                                              or die($pledge_statement->error);
	}
?>