<?php
	// This ajax block takes a section id and removes the section from a database.

	if(isset($_REQUEST['section_id'], $_REQUEST['test_id'])) {
		$section_id = $_REQUEST['section_id'];
		$test_id    = $_REQUEST['test_id'];
		
		//$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		//$delete_statement = $elite_connection->prepare("CALL delete_matching_section(?, ?)") or die($elite_connection->error);
		//$delete_statement->bind_param("ii", $section_id, $test_id)               or die($delete_statement->error);
		//$delete_statement->execute()                                           or die($delete_statement->error);
		
		echo 'everything works so far';
	}
?>