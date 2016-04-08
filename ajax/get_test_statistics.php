<?php
	// This AJAX block takes in a test id and returns the statistics for that test.
	$grade_alphabet   = range('A', 'D');
	$grade_alphabet[] = 'F';
	
	if(isset($_REQUEST["test_id"])) {
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		$statement = $elite_connection->prepare('SELECT get_test_letter_count(?, ?)');
		
		echo "<div>";
		foreach($grade_alphabet as $letter) {
			$statement->bind_param('is', $_REQUEST["test_id"], $letter);
			$statement->bind_result($grade_count);
			$statement->execute();
			$statement->fetch();
			echo "<span id='".$letter."' class='grade_count'>".$grade_count."</span>";
			
		}
		echo "</div>";
	}

?>