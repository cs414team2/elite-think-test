<?php
	// This AJAX block takes in a teacher id and returns the information associated with that teacher.
	
	require_once('../model/Teacher.php');
	
	if(isset($_REQUEST["teacher_id"])) {
		$teacher = new Teacher();
		
		echo '<div id="heading_info">';
		$teacher->get_teacher_info($_REQUEST["teacher_id"]);
		echo '</div>';
		
		echo '<table id="information_line"><tbody>';
		$teacher->get_full_teacher_info($_REQUEST["teacher_id"]);
		echo '</tbody></table>';
		
		echo '<table id="class_table"><tbody>';
		$teacher->print_classes($_REQUEST["teacher_id"]);
		echo '</tbody></table>';
	}

?>