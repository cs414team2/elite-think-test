<?php
require_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		$test = new Test($_REQUEST['test_id']);
		
		echo '
			<script src="controllers/test_grader.js"></script>
			<script>
				var test_id = '. $_REQUEST['test_id'] . ';
			</script>
			<div class="testContainer">
				<div id="sidebar" style="text-align:center; margin-top:3em;">
					<section style="text-align:center">
						<h2>Select a Test to Grade </h2>
							<section id="studentTest" style="max-height:600px; padding:1em; min-height:450px; margin-left:2em; margin-right:2em; overflow-y:auto; background-color:lightgray; ">';
								$test->get_completed_tests();
					echo	'</section>
					</section>
					<br /><br />
					<section id="test_guide" style="padding:1em; min-height:50px; margin-left:2em; margin-right:2em; background-color:lightgray; ">
					<h1> Grading Symbols </h1>
						<p> &#8656; - Student gave no answer <br \> &#10003; - Student gave correct answer  <br \> x - student gave wrong answer </p>
						
					
					</section>
						
				</div>		
		
				<div class="studentTest" style="float:right;">
					<button class="alt button special" style="float:right; margin-right:2em; margin-top:1em;" id="btn_finalize_grade">Finalize Grade</button>
					<h2 style="padding:10px;"><span id="grade_curr_stud_name"></span> Test '. $test->get_test_number() . ' - ' . $test->get_class_name() . '</h2>
					<section id="gradeView">
						<div id="grade_content" align="left" ';
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