<?php

	// This AJAX block takes in two questions and swaps them in a database.
	
	// Create the connection string.
	function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}

	if(isset($_REQUEST["section_id_1"], $_REQUEST["section_id_2"])) {
		$elite_connection = prepare_connection();
		$swap_statement   = $elite_connection->prepare("CALL swap_sections(?,?)") or die($elite_connection->error);
		$swap_statement->bind_param("ii", $_REQUEST["section_id_1"], $_REQUEST["section_id_2"]) or die($swap_statement->error);
		$swap_statement->execute() or die($swap_statement->error);
		
	}
	
?>