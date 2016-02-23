<?php
	if(isset($_REQUEST['class_id'] $_REQUEST['date_due'], $_REQUEST['date_active'], $_REQUEST['time_limit'])) {
		$class_id = $_REQUEST['class_id'];
		$date_due = $_REQUEST['date_due'];
		$date_active = $_REQUEST['date_active'];
		$time_limit = $_REQUEST['time_limit'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$addStatement = $eliteConnection->prepare("CALL create_test(?, ?, ?, ?, ?)") or die($eliteConnection->error);
		$addStatement->bind_param("iissi", $class_id, $date_due, $date_active, $time_limit);
		$addStatement->execute();
	}
?>