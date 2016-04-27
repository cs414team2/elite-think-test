<?php
require_once('model/Test.php');
require_once('model/StudentTest.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	if ($_SESSION['credentials']->is_student()) {
		$test = new Test($_REQUEST['test_id']);
		$student_test = new StudentTest($_REQUEST['test_id'], $_SESSION['credentials']->get_user_id());
		
		echo '
			<script src="controllers/student_test_viewer.js"></script>
			<script>
				var test_id = '. $_REQUEST['test_id'] . ';
			</script>
			<div class="testContainer">
				<div id="sidebar" class="sidebar" style="text-align:center; margin-top:3em;">
					<section style="text-align:center">
						<h2>Your Grade</h2>
						<h2 style="font-size: 72pt;">'.$student_test->get_letter_grade().'</h2>
						<h2>'.$student_test->get_number_grade().'%</h2>
					</section>
				</div>
		
				<div class="studentTest" style="float:right;">
					<h2 style="padding:10px;"><span id="grade_curr_stud_name"></span> Test '. $test->get_test_number() . ' - ' . $test->get_class_name() . '</h2>
					<section id="gradeView">
						<div id="grade_content" align="left" >';
							$student_test->print_test($_SESSION['credentials']->get_access_level());
				echo'	</div>
						<br />
					</section>
				</div>			

		';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>