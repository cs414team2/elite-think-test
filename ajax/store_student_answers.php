<?php
	foreach ($_REQUEST['test'] as $question) {
		echo $question['question_id'] . " - " . $question['answer'];
	}
?>