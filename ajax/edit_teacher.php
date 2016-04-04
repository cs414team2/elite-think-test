<?php
	// This AJAX block takes in a teacher's info and passes it to a database.

	if(isset($_REQUEST['id'], $_REQUEST['first_name'], $_REQUEST['last_name'], $_REQUEST['email'], $_REQUEST['password'])) {
		$id         = $_REQUEST['id'];
		$password   = htmlspecialchars(trim($_REQUEST['password']));
		$email      = htmlspecialchars(strtolower(trim($_REQUEST['email'])));
		$first_name = htmlspecialchars(ucwords(trim($_REQUEST['first_name'])));
		$last_name  = htmlspecialchars(ucwords(trim($_REQUEST['last_name'])));
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");		
		
		$edit_statement = $elite_connection->prepare("CALL edit_teacher(?, ?, ?, ?, ?)") or die($elite_connection->error);
		$edit_statement->bind_param("issss", $id, $first_name, $last_name, $email, $password) or die($edit_statement->error);
		$edit_statement->execute() or die($edit_statement->error);

		echo "<table><tbody><tr>
					<td id='info_id'>".$id."</td>
					<td id='info_first'>". $first_name ."</td>
					<td id='info_last'>". $last_name ."</td>
					<td id='info_email'>". $email ."</td>
					<td id='info_password'>". $password ."</td>
				</tr></tbody><table>
			  <div>" . $id . " &nbsp;&nbsp;</div>";
	}
?>