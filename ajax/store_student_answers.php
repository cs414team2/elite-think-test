<?php
	foreach ($_REQUEST['question'] as $question_id => $answer) {
		echo $question_id . " - " . $answer;
		
	}
?>