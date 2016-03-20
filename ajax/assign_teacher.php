<?php

	if(isset($_REQUEST['class_id'], $_REQUEST['teacher_id'])) {
		$class_id   = $_REQUEST['class_id'];
		$teacher_id = $_REQUEST['teacher_id'];
		
		if ($teacher_id == "null") {
			$teacher_id = null;
		}
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");		
		
		$assign_statement = $elite_connection->prepare("CALL set_class_teacher(?, ?)") or die($elite_connection->error);
		$assign_statement->bind_param("ii", $teacher_id, $class_id)                    or die($assign_statement->error);
		$assign_statement->execute()                                                   or die($assign_statement->error);
	}
?>