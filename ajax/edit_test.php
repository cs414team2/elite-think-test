<?php
	if(isset($_REQUEST['class_id'], $_REQUEST['date_due'], $_REQUEST['date_active'], $_REQUEST['time_limit'])) {
		$class_id = $_REQUEST['class_id'];
		$date_due = $_REQUEST['date_due'];
		$date_active = $_REQUEST['date_active'];
		$time_limit = $_REQUEST['time_limit'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		
		$editStatement = $eliteConnection->prepare("CALL edit_test(?, ?, ?, ?)") or die($eliteConnection->error);
		$editStatement->bind_param("issi", $class_id, $date_due, $date_active, $time_limit) or die($editStatement->error);
		$editStatement->execute() or die($editStatement->error);
	}
?>