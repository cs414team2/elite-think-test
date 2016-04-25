<?php
require_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		$test = new Test($_REQUEST['test_id']);
		
		echo '
			<script src="controllers/teacher_test_viewer.js"></script>
			<script>
				var test_id = '. $_REQUEST['test_id'] . ';
			</script>
			<div class="testContainer">
				<div id="sidebar" class="sidebar" style="text-align:center;">
					<section style="text-align:center">
						<h2 style="margin-left:1em; margin-right:1em;">Select a student&apos;s test to view their results </h2>
							<section id="studentTest" style="max-height:375px; padding:1em; min-height:300px; margin-left:2em; margin-right:2em; overflow-y:auto; background-color:lightgray; ">';
								$test->print_finished_students();
					echo	'</section>
					</section>
					
					<section id="test_guide" style="padding:1em; min-height:50px;  margin:1em; margin-left:2em; margin-right:2em; background-color:lightgray; ">
					<h1> Grading Symbols </h1>
					<ul style="list-style-type: none; text-align: left;">
						<li>&#8656; - Student gave no answer</li>
						<li>&#10003; - Student gave correct answer</li>
						<li>&#10006; - student gave wrong answer </li>
					</ul>
					
					</section>
						
				</div>		
		
				<div class="studentTest" style="float:right;">
					<h2 style="padding:10px;"><span id="test_curr_stud_name"></span> Test '. $test->get_test_number() . ' - ' . $test->get_class_name() . '</h2>
					<h2 id="h_grade" style="padding:10px;"><span id="stud_grade"></span> &nbsp;<span id="stud_letter_grade"></span></h2>
					<section id="gradeView">
						<div id="test_content" align="left" ';
						if (isset($_REQUEST['student_id'])){
							echo '>';
							require_once('model/StudentTest.php');
							$student_test = new StudentTest($_REQUEST['test_id'], $_REQUEST['student_id']);
							$student_test->print_test(Test::TEACHER);
						}
						else {
							echo 'style="display: none;">
							<div class="my-form-builder">
								<div class="loader">Loading...</div>
							</div>';
						}
						
					echo '
						</div>
						<div id="area_test_loader" style="display:none;" class="my-form-builder">
							<div   class="loader">Loading...</div>
						</div>
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