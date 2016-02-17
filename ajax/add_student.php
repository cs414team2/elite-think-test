<?php
	require_once('../model/CS414Connection.php');
	
	if(isset($_REQUEST['password'], $_REQUEST['email'], $_REQUEST['firstname'], $_REQUEST['lastname'])) {
		$password = trim($_REQUEST['password']);
		$email = trim($_REQUEST['email']);
		$first_name = trim($_REQUEST['firstname']);
		$last_name = trim($_REQUEST['lastname']);
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");		
		
		$addStatement = $eliteConnection->prepare("CALL create_student(?, ?, ?, ?)") or die($db->error);
		$addStatement->bind_param("ssss", $password, $email, $first_name, $last_name);
		$addStatement->execute();
	}
?>