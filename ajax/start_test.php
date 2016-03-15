<?php
	if(isset($_REQUEST['test_id'], $_REQUEST['student_id'])) {
		$test_id    = $_REQUEST['test_id'];
		$student_id = $_REQUEST['student_id'];
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		$add_statement = $elite_connection->prepare("CALL add_student_test(?,?)")                      or die("add_student_test:" . $add_statement->error);
		$add_statement->bind_param("ii", $student_id, $test_id)                                       or die("add_student_test:" . $add_statement->error);
		$add_statement->execute()                                                                    or die("add_student_test:" . $add_statement->error);
		
		$time_statement = $elite_connection->prepare("SELECT test_seconds_remaining(?, ?)") or die("test_seconds_remaining:" . $time_statement->error);
		$time_statement->bind_param("ii", $student_id, $test_id)                        or die("test_seconds_remaining:" . $time_statement->error);
		$time_statement->execute()                                                    or die("test_seconds_remaining:" . $time_statement->error);
		$time_statement->bind_result($time_remaining)                               or die("test_seconds_remaining:" . $time_statement->error);
		$time_statement->fetch()                                                  or die("test_seconds_remaining:" . $time_statement->error);
		
		echo $time_remaining;
	}
?>