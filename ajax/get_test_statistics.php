<?php
	// This AJAX block takes in a test id and returns the statistics for that test.
	$grade_alphabet   = range('A', 'D');
	$grade_alphabet[] = 'F';
	
	if(isset($_REQUEST['test_id'])) {
		
		$elite_connection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2") or die($elite_connection->error);
		
		// Print the frequency of each letter grade.
		$statement = $elite_connection->prepare('SELECT get_test_letter_count(?, ?)');
		echo '<div>';
		foreach($grade_alphabet as $letter) {
			$statement->bind_param('is', $_REQUEST['test_id'], $letter);
			$statement->bind_result($grade_count);
			$statement->execute();
			$statement->fetch();
			echo '<span id="'.$letter.'" class="grade_count">'.$grade_count.'</span>';
			
		}
		echo '</div>';
		$statement->close();
		
		// Print the question number of the most missed question and how many people missed that question.
		
		
		// Print the min, max, and average grades
		$statement = $elite_connection->prepare('SELECT max(grade) as max_grade, min(grade) as min_grade, avg(grade) as avg_grade
		                                           FROM student_test
												  WHERE test_id = ?');
		$statement->bind_param('i', $_REQUEST['test_id']);
		$statement->bind_result($max_grade, $min_grade, $avg_grade);
		$statement->execute();
		$statement->fetch();
		echo '<div id="highest_grade">' . number_format($max_grade, 1) .'</div>';
		echo '<div id="lowest_grade">'  . number_format($min_grade, 1) .'</div>';
		echo '<div id="average_grade">' . number_format($avg_grade, 1) .'</div>';
		
	}

?>