<?php
	// This ajax block takes an updated matching section and updates the section in the database.

	if(isset($_REQUEST['test_id'], $_REQUEST['section_id'], $_REQUEST['section_description'], $_REQUEST['question_weight'], $_REQUEST['questions'], $_REQUEST['answers'])) {
		$test_id             = $_REQUEST['test_id'];
		$section_id          = $_REQUEST['section_id'];
		$section_description = ucfirst(trim($_REQUEST['section_description']));
		$question_weight     = $_REQUEST['question_weight'];
		
		echo 'everything works so far';
	}
?>