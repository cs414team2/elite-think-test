<?php
	// This ajax block takes in a new student's name, password, and email address and
	// passes them to the cs414 database.

	require_once('../model/CS414Connection.php');
	
	if(isset($_REQUEST['password'], $_REQUEST['email'], $_REQUEST['firstname'], $_REQUEST['lastname'])) {
		$password   = htmlspecialchars(trim($_REQUEST['password']));
		$email      = htmlspecialchars(strtolower(trim($_REQUEST['email'])));
		$first_name = htmlspecialchars(ucwords(trim($_REQUEST['firstname'])));
		$last_name  = htmlspecialchars(ucwords(trim($_REQUEST['lastname'])));
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");		
		
		$addStatement = $eliteConnection->prepare("CALL create_student(?, ?, ?, ?)") or die($eliteConnection->error);
		$addStatement->bind_param("ssss", $password, $email, $first_name, $last_name);
		$addStatement->execute();
	}
?>