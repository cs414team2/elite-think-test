<?php
	const MAX_PERCENTAGE_MISSED = .40; // The percent of students to miss a question for the question to be listed
	const MIN_QUESTION_RESULTS  = 5;   // The minimum number of missed questions needed to list before decrementing the percent of students.
	const PERCENTAGE_DECREMENT  = .10; // How far to decrement the percentage missed

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
		$min_percent  = MAX_PERCENTAGE_MISSED;
		$min_question = MIN_QUESTION_RESULTS;
		echo '<div>';
		$statement = $elite_connection->prepare('SELECT times_missed, question_number
		                                           FROM missed_questions_count
												  WHERE test_id = ?
												    AND (times_missed/times_answered) >= ?
												  ORDER BY times_missed, question_number');
		$statement->bind_param('id', $_REQUEST['test_id'], $min_percent);
		$statement->bind_result($times_missed, $question_number);
		$statement->execute();
		$statement->store_result();

		while ($min_question > 0) {
			
			while ($min_percent > 0)  {
				
				$statement->execute();
				$statement->store_result();
				
				if ($statement->num_rows >= $min_question) {
					while($statement->fetch()) {
						echo '<span id="'.$question_number.'" class="missed_question_count">'.$times_missed.'</span>';
					}
					$min_percent = 0;
					$min_question = 0;
				}
				else {
					$min_percent = $min_percent - PERCENTAGE_DECREMENT;
				}
			}
			$min_question--;
			$min_percent = MAX_PERCENTAGE_MISSED;
		}
		
		echo '</div>';
		$statement->close();
		
		// Print the min, max, and average grades
		$statement = $elite_connection->prepare('SELECT max(grade) as max_grade, min(grade) as min_grade, avg(grade) as avg_grade
		                                           FROM student_test
												  WHERE test_id = ?');
		$statement->bind_param('i', $_REQUEST['test_id']);
		$statement->bind_result($max_grade, $min_grade, $avg_grade);
		$statement->execute();
		$statement->fetch();
		echo '<div id="highest_grade">' . number_format($max_grade) .'</div>';
		echo '<div id="lowest_grade">'  . number_format($min_grade) .'</div>';
		echo '<div id="average_grade">' . number_format($avg_grade) .'</div>';
		
	}

?>