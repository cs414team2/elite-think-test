<?php
	
	// This ajax block takes in a test id and removes that test.
	
	require_once("../model/ErrorLogger.php");
	
	function log_and_die($error) {
		new ErrorLogger('ajax/delete_test.php '.$error);
		die();
	}

	if(isset($_REQUEST['test_id'])) {
		$test_id = $_REQUEST['test_id'];

		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");

		$delete_statement = $elite_connection->prepare("CALL delete_test(?)") or log_and_die($elite_connection->error);
		$delete_statement->bind_param("i", $test_id)                       or log_and_die($delete_statement->error);
		$delete_statement->execute()                                     or log_and_die($delete_statement->error);
	}
?>