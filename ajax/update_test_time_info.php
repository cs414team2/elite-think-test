<?php
	if (isset($_REQUEST['test_id'], $_REQUEST['date_due'], $_REQUEST['date_active'], $_REQUEST['time_limit'])) {
		
		$date_due    = date('Y-m-d H:i:s', $_REQUEST['date_due']);
		$date_active = ($_REQUEST['date_active'] == null ? null : date('Y-m-d H:i:s', $_REQUEST['date_active']));
	
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2")         or die($elite_connection->error);
		$time_statement = $elite_connection->prepare("CALL edit_test(?,?, ?, ?)")                                 or die($elite_connection->error);
		$time_statement->bind_param("issi", $_REQUEST['test_id'], $date_due, $date_active, $_REQUEST['time_limit']) or die($time_statement->error);
		$time_statement->execute()                                                                                 or die($time_statement->error);
		
	}
?>