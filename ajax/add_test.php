<?php
	if(isset($_REQUEST['class_id'])) {
		$class_id = $_REQUEST['class_id'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$addStatement = $eliteConnection->prepare("CALL create_test(?)") or die($eliteConnection->error);
		$addStatement->bind_param("i", $class_id) or die($addStatement->error);
		$addStatement->execute() or die($addStatement->error);
	}
?>