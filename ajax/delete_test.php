<?php
	if(isset($_REQUEST['test_id'])) {
		$test_id = $_REQUEST['test_id'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$deleteStatement = $eliteConnection->prepare("SELECT delete_test(?)") or die($eliteConnection->error);
		$deleteStatement->bind_param("i", $test_id) or die($deleteStatement->error);
		$deleteStatement->execute() or die($deleteStatement->error);
	}
?>