<?php
	// This AJAX block takes in a student id and returns the information associated with that student.
	
	require_once('../model/Student.php');
	
	if(isset($_REQUEST["student_id"])) {
		$student = new Student();
		
		echo '<div id="heading_info">';
		$student->get_student_info($_REQUEST["student_id"]);
		echo '</div>';
		
		echo '<table id="information_line"><tbody>';
		$student->get_full_student_info($_REQUEST["student_id"]);
		echo '</tbody></table>';
		
		echo '<table id="class_table"><tbody>';
		$student->print_classes($_REQUEST["student_id"]);
		echo '</tbody></table>';
	}

?>