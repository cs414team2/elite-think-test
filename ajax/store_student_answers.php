<?php
	foreach ($_REQUEST as $answer_id => $answer) {
		echo $answer_id . " - " . $answer;
		
		if ($answer_id == "checkifitreallyisavalidanswercontrol") {
			//Store $answer in the database.
		}
	}
?>