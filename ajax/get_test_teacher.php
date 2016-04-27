<?php
	require_once('../model/StudentTest.php');
	require_once('../model/Session.php');
	if(isset($_REQUEST['student_id'], $_REQUEST['test_id'])) {
		$student_test = new StudentTest($_REQUEST['test_id'], $_REQUEST['student_id']);
		
		echo "<div id='test'>";
		$student_test->print_test(Session::STUDENT);
		echo "</div>";
		
		echo "<div id='grade'>".$student_test->get_number_grade()."</div>";
		
		echo "<div id='letter_grade'>".$student_test->get_letter_grade()."</div>";
	}
?>